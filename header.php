<?php
$pageTitle = $pageTitle ?? 'Campus Events Hub';
$currentPage = basename($_SERVER['PHP_SELF']);

function navClass(string $page, string $currentPage): string
{
    return $page === $currentPage ? 'active' : '';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="SEU Activities Club campus events and student registration website.">
    <title><?= e($pageTitle) ?> | SEU Activities Club</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<header class="site-header">
    <div class="container header-inner">
        <a class="brand" href="index.php" aria-label="Campus Events Hub home">
            <span class="brand-mark">SEU</span>
            <span>
                <strong>Campus Events Hub</strong>
                <small>SEU Activities Club</small>
            </span>
        </a>

        <nav class="main-nav" aria-label="Main navigation">
            <a class="<?= navClass('index.php', $currentPage) ?>" href="index.php">Home</a>
            <a class="<?= navClass('events.php', $currentPage) ?>" href="events.php">Events</a>
            <a class="<?= navClass('register.php', $currentPage) ?>" href="register.php">Register</a>
            <a class="<?= navClass('registrations.php', $currentPage) ?>" href="registrations.php">Registrations</a>
            <a class="<?= navClass('about.php', $currentPage) ?>" href="about.php">About</a>
            <a class="<?= navClass('contact.php', $currentPage) ?>" href="contact.php">Contact</a>
        </nav>
    </div>
</header>
<main>
