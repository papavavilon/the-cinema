<?php

// Передаємо дані до спільного шаблону сторінки.
function heading($label, $title, $text = "")
{
    require ROOT_PATH . "/frontend/views/layout/heading.php";
}
