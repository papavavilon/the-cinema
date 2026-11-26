<?php // Повідомлення від відвідувачів і відповіді працівника. ?>
<?php foreach ($messages as $m): ?>

    <article class="panel message">
        <p class="eyebrow"><?= e($m["Submitted_At"]) ?> · <?= e($m["Email"]) ?></p>
        <h2><?= e($m["Subject"]) ?></h2>
        <p><?= nl2br(e($m["Message"])) ?></p>

        <form method="post">
            <?php csrf(); ?>
            <input type="hidden" name="id" value="<?= $m["Message_ID"] ?>" />
            <label>
                Your reply
                <textarea name="reply" required><?= e($m["Reply"]) ?></textarea>
            </label>
            <button class="button small">Save reply to demo mailbox</button>
        </form>
    </article>

<?php endforeach; ?>
