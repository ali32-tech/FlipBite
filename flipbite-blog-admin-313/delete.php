<?php
require_once __DIR__ . '/auth.php';
require_login();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $slug = trim($_POST['slug'] ?? '');
    if (preg_match('/^[a-z0-9-]+$/', $slug)) {
        $file = __DIR__ . '/../posts/' . $slug . '.md';
        if (file_exists($file)) {
            unlink($file);
        }
    }
}

header('Location: index.php');
exit;
