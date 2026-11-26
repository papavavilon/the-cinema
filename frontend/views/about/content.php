<?php
/* Показуємо інформацію про кінотеатр. */ ?>
<main id="main" class="wrap section">
    <?php heading("YOUR CINEMA. YOUR CITY.", "Big screen. Good company."); ?>
    <div class="about-layout">
        <div class="brand-panel">
            <span class="eyebrow">ESBJERG / DENMARK</span>
            <div>
                Make time
                <br />
                for
                <em>cinema.</em>
            </div>
            <span>THECINEMA</span>
        </div>
        <div>
            <h2>
                A little escape.
                <br />
                A shared experience.
            </h2>
            <p class="lede"><?= nl2br(e($company["Description"])) ?></p>
            <a class="button" href="<?= url("movies") ?>">Find your next film ↗</a>
        </div>
    </div>
    <div class="info-grid">
        <div class="panel">
            <p class="eyebrow">FIND US</p>
            <h3>Right here in Esbjerg.</h3>
            <p><?= e($company["Location"]) ?></p>
        </div>
        <div class="panel">
            <p class="eyebrow">OPENING HOURS</p>
            <p><?= nl2br(e($company["OpeningHours"])) ?></p>
        </div>
        <div class="panel">
            <p class="eyebrow">SAY HELLO</p>
            <a href="mailto:<?= e($company["Email"]) ?>"><?= e($company["Email"]) ?></a>
            <p><a class="text-link" href="<?= url("contact") ?>">Send a message ↗</a></p>
        </div>
    </div>
    <?php require ROOT_PATH . "/frontend/views/about/halls.php"; ?>
</main>
