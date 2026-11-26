<?php

// Єдина точка входу. Приймаємо запит, перевіряємо форму й запускаємо потрібний контролер.
require __DIR__ . "/includes/bootstrap.php";
$path = trim($_GET["path"] ?? "", "/");
if ($path === "landing") {
    $path = "";
}
try {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        check_csrf();
        $actions = require ROOT_PATH . "/includes/actions.php";
        if (isset($actions[$path])) {
            (new ($actions[$path])($db))->handle($path);
        } elseif (strpos($path, "admin/") !== 0 && $path !== "setup") {
            throw new RuntimeException("Unknown action.");
        }
    }
    if (strpos($path, "admin/") === 0 || $path === "setup") {
        (new AdminController($db))->handle($path);
    } else {
        $routes = require ROOT_PATH . "/includes/routes.php";
        if (!isset($routes[$path])) {
            http_response_code(404);
            throw new RuntimeException("Page not found.");
        }
        (new ($routes[$path])($db))->handle($path);
    }
} catch (Throwable $error) {
    if ($db->inTransaction()) {
        $db->rollBack();
    }
    error_log((string) $error);
    if (http_response_code() < 400) {
        http_response_code(400);
    }
    $message =
        $error instanceof PDOException
            ? "The request could not be completed. Please check your details and try again."
            : $error->getMessage();
    page_head("Please try again");
    require ROOT_PATH . "/frontend/views/error.php";
    page_foot();
}
