<?php
/* Групуємо сеанси за днем і даємо посилання на вибір місць. */ ?>
<?php if (!$times): ?>
<p class="muted">
    No upcoming screenings yet. Check back soon.
</p>
<?php endif; ?>
<?php
$day = ""; foreach ($times as $time): ?>
<?php if ($day !== $time["ShowDate"]): ?>
<?php if ($day !== ""): ?>
</div>
</div>
<?php endif; ?>
<?php $day = $time["ShowDate"]; ?>
<div class="day-row">
    <h3>
        <?= e(date("D, j M", strtotime($day))) ?>
    </h3>
    <div class="time-list">
        <?php endif; ?>
        <a class="time-chip" href="<?= url("seat?screening_id=" . $time["Screening_ID"]) ?>">
            <?= e(substr($time["ShowTime"], 0, 5)) ?>
            <small>
                <?= e($time["Hall"]) ?>
            </small>
        </a>
        <?php endforeach; if ($times): ?>
    </div>
</div>
<?php endif; ?>
