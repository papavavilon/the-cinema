<?php
/* Показуємо денний розклад із робочої бази даних. */ ?>

<section class="wrap section">
    <div class="section-heading">
        <div>
            <p class="eyebrow">ON THE BIG SCREEN TODAY</p>
            <h2>Today at thecinema.</h2>
        </div>
        <a class="text-link" href="<?= url("movies?date=" . date("Y-m-d")) ?>">All films & times ↗</a>
    </div>
    <?php if (!$today): ?>
    <p class="muted">No screenings scheduled today. Browse films for another day.</p>
    <?php endif; ?>
    <div class="info-grid">
        <?php foreach ($today as $show): ?>

        <article class="panel">
            <p class="eyebrow"><?= e(substr($show["ShowTime"], 0, 5)) ?> · <?= e($show["Hall"]) ?></p>
            <h3><?= e($show["Title"]) ?></h3>
            <?php if (future_screening($show)): ?>
            <a class="text-link" href="<?= url("seat?screening_id=" . $show["Screening_ID"]) ?>">Choose seats ↗</a>
            <?php else: ?>
            <p class="muted">Screening has started</p>
            <?php endif; ?>
        </article>
        <?php endforeach; ?>
    </div>
</section>
