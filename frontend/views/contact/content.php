<?php
/* Показуємо форму зв’язку. */ ?>
<main id="main" class="wrap section">
    <?php heading(
            "LET’S TALK",
            "Hello, cinema lover.",
            "A question about your visit? Leave a message for the team."); ?>
    <div class="checkout-layout">

        <section>
            <h2>Come on over.</h2>
            <p class="lede"><?= e($company["Location"]) ?></p>
            <p><a class="text-link" href="mailto:<?= e($company["Email"]) ?>"><?= e($company["Email"]) ?></a></p>
            <p><?= nl2br(e($company["OpeningHours"])) ?></p>
        </section>

        <form class="panel" method="post">
            <?php csrf(); ?>
            <label>
                Name
                <input name="name" required maxlength="100" autocomplete="name" />
            </label>
            <label>
                Email
                <input type="email" name="email" required maxlength="100" autocomplete="email" />
            </label>
            <label>
                Subject
                <input name="subject" required maxlength="255" />
            </label>
            <label>
                Your message
                <textarea name="message" rows="5" required maxlength="5000"></textarea>
            </label>
            <button class="button">Send message ↗</button>
            <p class="muted">In this demo, messages are saved in the staff dashboard.</p>
        </form>
    </div>
</main>
