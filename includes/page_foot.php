<?php

// Передаємо дані до спільного шаблону сторінки.
function page_foot()
{
    global $db;
    $co = (new AboutModel($db))->company();
    require ROOT_PATH . "/frontend/views/layout/page_foot.php";
}
