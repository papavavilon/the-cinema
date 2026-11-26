<?php // Локальні копії листів для перевірки роботи сайту. ?>
<p class="notice">
        Local copies of outgoing messages. Email delivery is available when the cinema mail service is configured.
    </p>
    <?php foreach ( $letters as $m): ?>

    <article class="panel message">
        <p class="eyebrow"><?= e($m["CreatedAt"]) ?> / <?= e($m["Recipient"]) ?></p>
        <h3><?= e($m["Subject"]) ?></h3>
        <p class="mail-body"><?= nl2br(e($m["Body"])) ?></p>
    </article>

<?php endforeach; ?>
