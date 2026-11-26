<?php

// Допоміжна перевірка частоти запитів.
function rate_limit($key)
{
    global $db;
    $model = new AccountModel($db);
    $ip = $_SERVER["REMOTE_ADDR"] ?? "";
    $count = $model->countAuthAttempts([$ip, $key])->fetchColumn();
    if ($count >= 15) {
        throw new RuntimeException("Too many attempts. Please try again in 10 minutes.");
    }
    $model->insertAuthAttempts([$ip, $key]);
}
