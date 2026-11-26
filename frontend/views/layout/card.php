<?php
/* Спільний елемент оформлення сторінок. */ ?>

<article class="film-card">
    <a href="<?= url("movie?movie_id=" . $m["Movie_ID"]) ?>">
        <div class="poster-wrap">
            <img
                src="<?= e(poster($m)) ?>"
                alt="<?= e($m["Title"]) ?> poster"
                loading="lazy"
                width="540"
                height="810"
            />
            <span class="poster-tag"><?= $m["Year"] >= 2025 ? "NEW RELEASE" : "THE CLASSICS" ?></span>
            <span class="poster-arrow">↗</span>
        </div>
        <div class="film-meta">
            <span><?= e($m["Genre"]) ?></span>
            <span><?= e($m["Year"]) ?></span>
        </div>
        <h3><?= e($m["Title"]) ?></h3>
        <p>
            <?= minutes($m["Duration"]) ?> min
            <span>·</span>
            <?= e($m["Format"]) ?>
        </p>
    </a>
</article>
