<?php
/* Показуємо зрозуміле повідомлення про помилку. */ ?>
<main id="main" class="wrap narrow section">
    <p class="eyebrow">thecinema</p>
    <h1>Let’s try that again.</h1>
    <p class="notice"><?= e($message) ?></p>
    <a class="button" href="<?= url("movies") ?>">Browse films</a>
</main>
