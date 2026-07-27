<?php
$isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
    || (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https');

session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'httponly' => true,
    'secure' => $isHttps,
    'samesite' => 'Lax',
]);
session_start();

// Never let the browser (or a shared cache) keep a copy of admin pages —
// this is what makes the back button show a stale page after logout.
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');
header('Expires: 0');

define('ADMIN_USERNAME', 'aliadursh');
define('ADMIN_PASSWORD_HASH', '$2y$10$GhSJfeiMs./4Q53NStIyI.2YjtreS7tBvcFkh44UZAoNcgLAU1sLS');

function require_login() {
    if (empty($_SESSION['flipbite_admin_logged_in'])) {
        header('Location: login.php');
        exit;
    }
}

function slugify($text) {
    $text = strtolower(trim($text));
    $text = preg_replace('/[^a-z0-9]+/', '-', $text);
    return trim($text, '-');
}
