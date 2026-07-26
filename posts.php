<?php
// Scans /posts for markdown files, parses their frontmatter, and returns
// them as JSON. Runs on every request — no build step needed, so a post
// added via /admin (or uploaded manually) shows up immediately.

header('Content-Type: application/json');

$postsDir = __DIR__ . '/posts';
$posts = [];

if (is_dir($postsDir)) {
    foreach (scandir($postsDir) as $file) {
        if (substr($file, -3) !== '.md') continue;

        $raw = file_get_contents($postsDir . '/' . $file);
        $slug = substr($file, 0, -3);
        $data = [
            'slug' => $slug,
            'title' => $slug,
            'date' => '',
            'category' => 'General',
            'excerpt' => '',
            'author' => 'FlipBite Team',
            'author_role' => '',
            'image' => '',
            'featured' => false,
        ];

        if (preg_match('/^---\r?\n(.*?)\r?\n---/s', $raw, $matches)) {
            foreach (preg_split('/\r?\n/', $matches[1]) as $line) {
                if (preg_match('/^([a-zA-Z0-9_]+):\s*(.*)$/', $line, $lineMatch)) {
                    $value = trim($lineMatch[2]);
                    if (
                        (str_starts_with($value, '"') && str_ends_with($value, '"')) ||
                        (str_starts_with($value, "'") && str_ends_with($value, "'"))
                    ) {
                        $value = substr($value, 1, -1);
                    } elseif ($value === 'true') {
                        $value = true;
                    } elseif ($value === 'false') {
                        $value = false;
                    }
                    $data[$lineMatch[1]] = $value;
                }
            }
        }

        $posts[] = $data;
    }
}

usort($posts, function ($a, $b) {
    return strtotime($b['date']) <=> strtotime($a['date']);
});

echo json_encode(array_values($posts), JSON_PRETTY_PRINT);
