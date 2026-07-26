<?php
session_start();

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
