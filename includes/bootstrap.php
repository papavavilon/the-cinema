<?php

// Завантажуємо класи, налаштування бази та захищену сесію відвідувача.
define("ROOT_PATH", dirname(__DIR__));
spl_autoload_register(function (string $class): void {
    foreach (
        [
            "includes",
            "frontend/models",
            "frontend/controllers",
            "admin/models",
            "admin/controllers",
            "services"
        ]
        as $folder
    ) {
        $file = ROOT_PATH . "/" . $folder . "/" . $class . ".php";
        if (is_file($file)) {
            require_once $file;
            return;
        }
    }
});
$config = require ROOT_PATH . "/config/database.php";
date_default_timezone_set($config["timezone"]);
session_name("THECINEMA_SESSION");
ini_set("session.use_strict_mode", "1");
session_set_cookie_params([
    "httponly" => true,
    "samesite" => "Lax",
    "secure" => !empty($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] !== "off"
]);
session_start();
// Якщо XAMPP вимкнено, показуємо коротке повідомлення замість технічної помилки.
try {
    $db = (new Database($config))->connection();
} catch (PDOException $error) {
    http_response_code(503);
    error_log('The Cinema database connection failed.');
    exit('<h1>The Cinema</h1><p>Start MySQL in XAMPP and reload this page.</p>');
}
foreach (
    [
        "helpers",
        "security",
        "uploads",
        "rate_limit",
        "movie",
        "screening",
        "selection",
        "coupon",
        "outbox",
        "page_head",
        "page_foot",
        "card",
        "heading"
    ]
    as $helper
) {
    require_once ROOT_PATH . "/includes/" . $helper . ".php";
}
