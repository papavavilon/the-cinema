<?php
/* Показуємо обраний фільм. */ ?>
<main id="main">

    <section class="detail-hero">
        <img class="hero-background" src="<?= e(backdrop($movie)) ?>" alt="" aria-hidden="true">
        <div class="wrap detail-content">
            <img class="detail-poster" src="<?= e(poster($movie)) ?>" alt="<?= e($movie["Title"]) ?> poster" />
            <div>
                <p class="eyebrow"><?= $movie["Year"] >= 2025 ? "THE NEW RELEASES" : "THE CLASSICS" ?> / <?= e($movie["Year"]) ?></p>
                <h1><?= e($movie["Title"]) ?></h1>
                <div class="chips">
                    <span><?= minutes($movie["Duration"]) ?> min</span>
                    <span><?= e($movie["Genre"]) ?></span>
                    <span><?= e($movie["Format"]) ?></span>
                    <span><?= e($movie["Language"]) ?></span>
                </div>
                <p class="lede"><?= e($movie["Description"]) ?></p>
                <p class="muted">Directed by <?= e($movie["Director"]) ?></p>
                <a class="button" href="#showtimes">Choose a showtime ↓</a>
            </div>
        </div>
    </section>

    <section id="showtimes" class="wrap section">
        <p class="eyebrow">MAKE A NIGHT OF IT</p>
        <h2>Pick your moment.</h2>
        <p class="muted">Upcoming screenings · next 14 days · from 100 DKK</p>
        <?php require ROOT_PATH . "/frontend/views/components/showtimes.php"; ?>
    </section>
    <?php if (
            $movie["TrailerLink"] &&
            preg_match("~^https://www.youtube.com/embed/[A-Za-z0-9_-]+~", $movie["TrailerLink"])
): ?>

    <section class="wrap section trailer-section">
        <h2>A little preview.</h2>
        <iframe
            loading="lazy"
            src="<?= e($movie["TrailerLink"]) ?>"
            title="<?= e($movie["Title"]) ?> official trailer"
            allowfullscreen
            referrerpolicy="strict-origin-when-cross-origin"
        ></iframe>
    </section>
    <?php endif; ?>
</main>
