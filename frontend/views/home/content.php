<?php
/* Показуємо головну сторінку. */ ?>

<main id="main">

    <?php // Головний фільм і посилання на його сеанси. ?>
    <section class="hero">
        <img class="hero-background" src="<?= e(backdrop($hero)) ?>" alt="" aria-hidden="true">
        <div class="hero-shade"></div>
        <div class="wrap hero-inner">
            <div class="hero-copy">
                <p class="eyebrow">ESBJERG / LIGHTS DOWN. WORLD OFF.</p>
                <p class="hero-kicker">IN THE SPOTLIGHT</p>
                <h1><?= e($hero["Title"]) ?></h1>
                <p class="hero-meta">
                    <?= e($hero["Year"]) ?>
                    <span>/</span>
                    <?= e($hero["Genre"]) ?>
                    <span>/</span>
                    <?= minutes($hero["Duration"]) ?> MIN
                </p>
                <p class="hero-description"><?= e($hero["Description"]) ?></p>
                <a class="button" href="<?= url("movie?movie_id=" . $hero["Movie_ID"] . "#showtimes") ?>">
                    Find your seat
                    <span>↗</span>
                </a>
            </div>
            <div class="hero-bottom">
                <span>GOOD FILMS. BETTER TOGETHER.</span>
                <div class="spotlight-links">
                    <?php foreach ( $featured as $i => $featuredMovie): ?>
                    <a href="<?= url("movie?movie_id=" . $featuredMovie["Movie_ID"]) ?>">
                        <span>0<?= $i + 1 ?></span>
                        <?= e($featuredMovie["Title"]) ?>
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>

    <?php // Добірка фільмів або новин із бази. ?>
    <section class="wrap section">
        <div class="section-heading">
            <div>
                <p class="eyebrow">YOUR NEXT BIG-SCREEN MOMENT</p>
                <h2>
                    Something new.
                    <span class="accent">Something you.</span>
                </h2>
            </div>
            <a class="text-link" href="<?= url("movies") ?>">All films & times ↗</a>
        </div>
        <div class="film-grid"><?php foreach ($new as $movie) { card($movie); } ?></div>
    </section>

    <?php // Добірка класичних фільмів. ?>
    <section class="classic-section">
        <div class="wrap section">
            <div class="section-heading">
                <div>
                    <p class="eyebrow">BACK WHERE THEY BELONG</p>
                    <h2>The classics.</h2>
                </div>
                <a class="text-link" href="<?= url("movies?collection=classics") ?>">Rediscover a favourite ↗</a>
            </div>
            <div class="film-grid four"><?php foreach ($classics as $movie) { card($movie); } ?></div>
        </div>
    </section>

    <?php // Добірка фільмів або новин із бази. ?>
    <section class="wrap section">
        <div class="section-heading">
            <div>
                <p class="eyebrow">NOTES FROM YOUR CINEMA</p>
                <h2>The Cinema Journal.</h2>
            </div>
            <a class="text-link" href="<?= url("news") ?>">Read the journal ↗</a>
        </div>
        <div class="journal-grid">
            <?php foreach ( $latestNews as $i => $article): ?>
            <a class="journal-card" href="<?= url("news#article-" . $article["News_ID"]) ?>">
                <span class="journal-number">0<?= $i + 1 ?></span>
                <p class="eyebrow"><?= e(date("d M Y", strtotime($article["DatePosted"]))) ?></p>
                <h3><?= e($article["Title"]) ?></h3>
                <span class="text-link">Read story ↗</span>
            </a>
            <?php endforeach; ?>
        </div>
    </section>
    <?php require ROOT_PATH . "/frontend/views/home/today.php"; ?>

        <?php // Опис кінотеатру, який можна змінити в адмінпанелі. ?>
<section class="about-strip wrap">
        <p class="eyebrow">THIS IS THECINEMA</p>
        <h2>
            Your next great night
            <br />
            starts here
            <span class="accent">.</span>
        </h2>
        <p><?= nl2br(e($company["Description"])) ?></p>
        <a class="button outline" href="<?= url("about") ?>">Meet your cinema ↗</a>
    </section>
</main>
