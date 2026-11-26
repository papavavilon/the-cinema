<?php
/* Спільний елемент оформлення сторінок. */ ?>
<div class="page-heading">
    <p class="eyebrow"><?= e($label) ?></p>
    <h1><?= e($title) ?></h1>
    <?php if ( $text): ?>
    <p class="lede"><?= e($text) ?></p>
    <?php endif; ?>
</div>
