<?php
/* Показуємо новини кінотеатру. */ ?>
<main id="main" class="wrap section">
    <?php heading(
        "BEYOND THE SCREEN",
        "The Cinema Journal.",
        "Film discoveries, familiar favourites and a little inspiration for your next visit."); ?>
    <div class="stories">
        <?php foreach ($news as $i => $article): ?>

        <article class="story" id="article-<?= $article["News_ID"] ?>">
            <span class="journal-number">0<?= $i + 1 ?></span>
            <div>
                <p class="eyebrow"><?= e(date("d M Y", strtotime($article["DatePosted"]))) ?></p>
                <h2><?= e($article["Title"]) ?></h2>
                <p class="lede"><?= nl2br(e($article["Content"])) ?></p>
            </div>
        </article>
        <?php endforeach; ?>
    </div>
</main>
