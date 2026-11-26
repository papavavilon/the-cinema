<?php
/* Спільний елемент оформлення сторінок. */ ?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="theme-color" content="#18191b" />
        <meta
            name="description"
            content="thecinema, Esbjerg. Discover new releases, revisit classics and choose your next cinema night."
        />
        <title><?= e($title) ?> · thecinema</title>
        <link rel="icon" href="<?= url("assets/favicon.svg") ?>" type="image/svg+xml" />
        <link rel="stylesheet" href="<?= url('frontend/assets/css/base.css?v=3') ?>">
        <link rel="stylesheet" href="<?= url('frontend/assets/css/home.css?v=3') ?>">
        <link rel="stylesheet" href="<?= url('frontend/assets/css/movie.css?v=3') ?>">
        <link rel="stylesheet" href="<?= url('frontend/assets/css/booking.css?v=3') ?>">
        <link rel="stylesheet" href="<?= url('frontend/assets/css/pages.css?v=3') ?>">
        <link rel="stylesheet" href="<?= url('frontend/assets/css/admin.css?v=3') ?>">
        <link rel="stylesheet" href="<?= url('frontend/assets/css/responsive.css?v=3') ?>">
    </head>
    <body class="<?= $admin ? "admin-page" : "" ?>">
        <a class="skip" href="#main">Skip to content</a>
        <header class="site-header">
            <a class="wordmark" href="<?= url() ?>" aria-label="thecinema home">
                thecinema<span>•</span>
            </a>
            <button type="button" class="menu-toggle" aria-expanded="false" aria-controls="mainnav">
                Menu ☰
            </button>
            <nav id="mainnav" aria-label="Main navigation">
                <a href="<?= url("movies") ?>">Films & times</a>
                <a href="<?= url("news") ?>">Journal</a>
                <a href="<?= url("about") ?>">Our cinema</a>
                <a href="<?= url("contact") ?>">Contact</a>
            </nav>
            <div class="header-account">
                <?php if ( !empty($_SESSION["user_id"])): ?>
                <a class="button small outline" href="<?= url("user/profiles") ?>">My tickets ↗</a>
                <?php else: ?>
                <a class="button small outline" href="<?= url("user/login") ?>">Sign in ↗</a>
                <?php endif; ?>
            </div>
        </header>
        <?php if ($flash): ?>
        <div class="wrap flash" role="status"><?= e($flash) ?></div>
        <?php endif; ?>
