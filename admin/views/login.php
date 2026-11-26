<?php
/* Показуємо форму входу адміністратора. */ ?>
<main id="main" class="wrap narrow section">
    <?php heading("THECINEMA / STAFF", "Behind the scenes."); ?>

    <form method="post" class="panel">
        <?php csrf(); ?>
        <label>
            Email
            <input type="email" name="email" required autocomplete="username" />
        </label>
        <label>
            Password
            <input type="password" name="password" required autocomplete="current-password" />
        </label>
        <button class="button">Sign in ↗</button>
    </form>
    <?php if ( local_request() && !$adminCount): ?>
    <p><a class="text-link" href="<?= url("setup") ?>">First time? Set up your staff account ↗</a></p>
    <?php endif; ?>
</main>
