<?php
// Generates sitemap.xml on every request — static pages plus every
// published blog post, so new posts are indexed automatically.
header('Content-Type: application/xml; charset=UTF-8');

$baseUrl = 'https://flipbite.com';

$staticPages = [
    ['path' => '/', 'priority' => '1.0'],
    ['path' => '/blog', 'priority' => '0.8'],
    ['path' => '/link-building', 'priority' => '0.7'],
    ['path' => '/influencer-marketing', 'priority' => '0.7'],
    ['path' => '/contact', 'priority' => '0.6'],
];

$posts = [];
$postsDir = __DIR__ . '/posts';
if (is_dir($postsDir)) {
    foreach (scandir($postsDir) as $file) {
        if (substr($file, -3) !== '.md') continue;
        $slug = substr($file, 0, -3);
        $date = '';
        $raw = file_get_contents($postsDir . '/' . $file);
        if (preg_match('/^date:\s*"?([^"\r\n]*)"?\s*$/m', $raw, $m)) {
            $date = trim($m[1]);
        }
        $posts[] = ['slug' => $slug, 'date' => $date];
    }
}

echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

foreach ($staticPages as $page) {
    echo "  <url>\n";
    echo "    <loc>{$baseUrl}{$page['path']}</loc>\n";
    echo "    <priority>{$page['priority']}</priority>\n";
    echo "  </url>\n";
}

foreach ($posts as $post) {
    echo "  <url>\n";
    echo "    <loc>{$baseUrl}/post?slug=" . urlencode($post['slug']) . "</loc>\n";
    if ($post['date']) {
        $timestamp = strtotime($post['date']);
        if ($timestamp) {
            echo "    <lastmod>" . date('Y-m-d', $timestamp) . "</lastmod>\n";
        }
    }
    echo "    <priority>0.6</priority>\n";
    echo "  </url>\n";
}

echo '</urlset>' . "\n";
