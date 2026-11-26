<?php
/* Створюємо перший обліковий запис адміністратора. */ ?>
<main id="main" class="wrap narrow section">
    <?php heading(
        "ONE-TIME LOCAL SETUP",
        "Your cinema starts here.",
        "Create your staff account. This setup page closes after the first account is created."); ?>

    <form method="post" class="panel">
        <?php csrf(); ?>
        <label>
            Email
            <input type="email" name="email" required autocomplete="username" />
        </label>
        <label>
            Password
            <input
                type="password"
                name="password"
                minlength="10"
                maxlength="72"
                required
                autocomplete="new-password"
            />
        </label>
        <button class="button">Create staff account ↗</button>
    </form>
</main>
