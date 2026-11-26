<?php
/* Показуємо форму входу або реєстрації. */ ?>
<main id="main" class="wrap narrow section">
    <?php heading("THECINEMA / YOUR ACCOUNT", $title); ?>

    <form class="panel" method="post">
        <?php
        csrf(); if ( $register): ?>
        <label>
            Username
            <input name="name" required pattern="[a-zA-Z0-9_]{3,30}" autocomplete="username" />
        </label>
        <?php endif; if (!$reset): ?>
        <label>
            <?= $register || $forgot ? "Email" : "Email or username" ?>
            <input name="email" type="<?= $register || $forgot ? "email" : "text" ?>"
                required autocomplete="<?= $register || $forgot ? "email" : "username" ?>" />
        </label>
        <?php endif; if (!$forgot): ?>
        <label>
            <?= $reset ? "New password" : "Password" ?>
            <input
                name="password"
                type="password"
                required
                minlength="<?= $register || $reset ? 10 : 1 ?>"
                maxlength="72"
                autocomplete="<?= $register || $reset ? "new-password" : "current-password" ?>"
            />
        </label>
        <?php if ( $register || $reset): ?>
        <p class="muted">Use at least 10 characters.</p>
        <?php endif;endif; if ( $register): ?>
        <label>
            Phone
            <small>(optional)</small>
            <input name="phone" type="tel" maxlength="25" autocomplete="tel" />
        </label>
        <?php endif; if ($reset): ?>
        <input type="hidden" name="token" value="<?= e($_GET["token"] ?? "") ?>" />
        <?php endif; ?>
        <button class="button"><?= $register ? "Create account" : ($forgot ? "Request reset" : ($reset ? "Save password" : "Sign in")) ?> ↗</button>
    </form>
    <p class="account-links">
        <a href="<?= url("user/login") ?>">Sign in</a>
        <a href="<?= url("user/new_user") ?>">Create account</a>
        <a href="<?= url("user/forgot-password") ?>">Forgot password?</a>
    </p>
</main>
