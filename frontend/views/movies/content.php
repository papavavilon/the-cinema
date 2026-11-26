<?php
/* Показуємо каталог фільмів. */ ?>
<main id="main" class="wrap section">
    <?php heading(
        "PICK YOUR NEXT NIGHT OUT",
        "Find your film.",
        "A fresh discovery or an old favourite. There’s a seat for you."); ?>

    <form class="filter-bar" method="get" action="<?= url("movies") ?>">
        <label>
            Find a film
            <input type="search" name="q" value="<?= e($term) ?>" placeholder="Search by title" />
        </label>
        <label>
            Collection
            <select name="collection">
                <option value="">All films</option>
                <option value="new" <?= $collection === "new" ? "selected" : "" ?>>2025 / 2026 releases</option>
                <option value="classics" <?= $collection === "classics" ? "selected" : "" ?>>The classics</option>
            </select>
        </label>
        <label>
            Date
            <input type="date" name="date" min="<?= date("Y-m-d") ?>" value="<?= e($date) ?>" />
        </label>
        <button class="button">Find films ↗</button>
        <a class="text-link" href="<?= url("movies") ?>">Reset</a>
    </form>
    <p class="muted"><?= count($movies) ?> films in this collection</p>
    <div class="film-grid four"><?php foreach ($movies as $movie) { card($movie); } ?></div>
    <?php if (!$movies): ?>
    <div class="empty-state">
        <h2>No films match just yet.</h2>
        <a href="<?= url("movies") ?>">Clear your filters ↗</a>
    </div>
    <?php endif; ?>
</main>
