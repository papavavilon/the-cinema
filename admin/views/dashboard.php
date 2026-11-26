<?php
/* Показуємо меню, форми та таблиці адміністратора. */ ?>
<main id="main" class="wrap section">
    <div class="admin-heading">
        <div>
            <p class="eyebrow">THECINEMA / BEHIND THE SCENES</p>
            <h1><?= e(
                $sec["title"] ??
                    ([
                        "admin/manage-bookings" => "Bookings",
                        "admin/manage-messages" => "Messages",
                        "admin/outbox" => "Local demo mailbox",
][$path] ??
                        "Your cinema.")) ?></h1>
        </div>

        <form method="post" action="<?= url("admin/logout") ?>">
            <?php csrf(); ?>
            <button class="button outline small">Sign out</button>
        </form>
    </div>
    <nav class="admin-nav" aria-label="Staff navigation">
        <a href="<?= url("admin/dashboard") ?>">Overview</a>
        <?php foreach ($sections as $k => $v): ?>
        <a href="<?= url("admin/manage-" . $k) ?>"><?= e($v["title"]) ?></a>
        <?php endforeach; ?>
        <a href="<?= url("admin/manage-bookings") ?>">Bookings</a>
        <a href="<?= url("admin/manage-messages") ?>">Messages</a>
        <a href="<?= url("admin/outbox") ?>">Demo mailbox</a>
    </nav>
    <?php
    // Завантажуємо шаблон потрібного розділу.
    $view = $sec ? 'content' : ([
        'admin/manage-messages' => 'messages',
        'admin/outbox' => 'mail',
        'admin/manage-bookings' => 'bookings',
][$path] ?? 'overview');
    require ROOT_PATH . '/admin/views/' . $view . '.php';
    ?>
</main>
