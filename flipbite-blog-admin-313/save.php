<?php
require_once __DIR__ . '/auth.php';
require_login();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$postsDir = __DIR__ . '/../posts';
$originalSlug = trim($_POST['original_slug'] ?? '');
$title = trim($_POST['title'] ?? '');
$date = trim($_POST['date'] ?? date('Y-m-d'));
$category = trim($_POST['category'] ?? 'General');
$excerpt = trim($_POST['excerpt'] ?? '');
$author = trim($_POST['author'] ?? 'FlipBite Team');
$authorRole = trim($_POST['author_role'] ?? '');
$featured = isset($_POST['featured']) ? 'true' : 'false';
$body = trim($_POST['body'] ?? '');
$existingImage = trim($_POST['existing_image'] ?? '');
$removeImage = isset($_POST['remove_image']);

if ($title === '') {
    die('Title is required.');
}

// Determine the slug: keep it stable on edit, generate fresh (and unique) on create.
if ($originalSlug !== '' && preg_match('/^[a-z0-9-]+$/', $originalSlug) && file_exists($postsDir . '/' . $originalSlug . '.md')) {
    $slug = $originalSlug;
} else {
    $slug = slugify($title);
    $base = $slug;
    $i = 2;
    while (file_exists($postsDir . '/' . $slug . '.md')) {
        $slug = $base . '-' . $i;
        $i++;
    }
}

// Image: keep the existing one unless removed, or replace it with a new upload.
$imagesDir = $postsDir . '/images';
if (!is_dir($imagesDir)) {
    mkdir($imagesDir, 0755, true);
}

$image = $existingImage;

if ($removeImage && $image !== '') {
    $oldPath = __DIR__ . '/../' . $image;
    if (file_exists($oldPath)) unlink($oldPath);
    $image = '';
}

if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $allowed = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/gif' => 'gif', 'image/webp' => 'webp'];
    $imageInfo = @getimagesize($_FILES['image']['tmp_name']);
    $mime = $imageInfo['mime'] ?? '';
    if (isset($allowed[$mime])) {
        // Drop any previous image for this post first, in case the extension changed.
        if ($image !== '') {
            $oldPath = __DIR__ . '/../' . $image;
            if (file_exists($oldPath)) unlink($oldPath);
        }
        $ext = $allowed[$mime];
        $filename = $slug . '-' . time() . '.' . $ext;
        move_uploaded_file($_FILES['image']['tmp_name'], $imagesDir . '/' . $filename);
        $image = 'posts/images/' . $filename;
    }
}

function yamlEscape($value) {
    $value = str_replace('"', '\\"', $value);
    return '"' . $value . '"';
}

$frontmatter = "---\n";
$frontmatter .= "title: " . yamlEscape($title) . "\n";
$frontmatter .= "date: " . yamlEscape($date) . "\n";
$frontmatter .= "category: " . yamlEscape($category) . "\n";
$frontmatter .= "excerpt: " . yamlEscape($excerpt) . "\n";
$frontmatter .= "author: " . yamlEscape($author) . "\n";
$frontmatter .= "author_role: " . yamlEscape($authorRole) . "\n";
$frontmatter .= "featured: " . $featured . "\n";
$frontmatter .= "image: " . yamlEscape($image) . "\n";
$frontmatter .= "---\n\n";

file_put_contents($postsDir . '/' . $slug . '.md', $frontmatter . $body . "\n");

header('Location: index.php');
exit;
