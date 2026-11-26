<?php

// Передаємо дані до спільного шаблону сторінки.
function page_head($title, $admin = false)
{
    $flash = $_SESSION["flash"] ?? "";
    unset($_SESSION["flash"]);
    require ROOT_PATH . "/frontend/views/layout/page_head.php";
}
