<?php
/* Перелік залів завантажено з бази даних. */ ?>

<section class="section">
    <p class="eyebrow">OUR VENUES</p>
    <h2>Find your favourite screen.</h2>
    <div class="info-grid">
        <?php foreach ($halls as $hall): ?>

        <article class="panel">
            <h3><?= e($hall["Name"]) ?></h3>
            <p><?= e($hall["TotalSeats"]) ?> seats</p>
        </article>
        <?php endforeach; ?>
    </div>
</section>
