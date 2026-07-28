<?php
require_once __DIR__ . '/auth.php';
require_login();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $slug = trim($_POST['slug'] ?? '');
    if (preg_match('/^[a-z0-9-]+$/', $slug)) {
        $file = __DIR__ . '/../posts/' . $slug . '.md';
        if (file_exists($file)) {
            $raw = file_get_contents($file);
            if (preg_match('/^---\r?\n(.*?)\r?\n---/s', $raw, $m) && preg_match('/^image:\s*"?([^"\r\n]*)"?\s*$/m', $m[1], $im)) {
                $image = trim($im[1]);
                if ($image !== '') {
                    $imagePath = __DIR__ . '/../' . $image;
                    if (file_exists($imagePath)) unlink($imagePath);
                }
            }
            unlink($file);
        }
    }
}

header('Location: index.php');
exit;
