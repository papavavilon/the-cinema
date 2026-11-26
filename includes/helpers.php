<?php

// Форматуємо текст, ціни, посилання та повідомлення для сторінок.
function e($v)
{
    return htmlspecialchars(
        html_entity_decode((string) $v, ENT_QUOTES | ENT_HTML5, "UTF-8"),
        ENT_QUOTES,
        "UTF-8"
    );
}

function url($path = "")
{
    return "/dwp/" . ltrim($path, "/");
}

function go($path = "")
{
    header("Location: " . url($path), true, 303);
    exit();
}

function flash($text)
{
    $_SESSION["flash"] = $text;
}

function minutes($time)
{
    $p = explode(":", $time);
    return (int) $p[0] * 60 + (int) ($p[1] ?? 0);
}

function money($n)
{
    return number_format((float) $n, 2) . " DKK";
}

function poster($m)
{
    return url("uploads/poster/" . rawurlencode($m["Poster"] ?? ""));
}

function backdrop($m)
{
    return url("uploads/gallery/" . rawurlencode($m["Backdrop"] ?? ""));
}

function future_screening($s)
{
    return $s && strtotime($s["ShowDate"] . " " . $s["ShowTime"]) > time();
}

function local_request()
{
    return in_array($_SERVER["REMOTE_ADDR"] ?? "", ["127.0.0.1", "::1"], true);
}

function password_ok($s)
{
    return strlen($s) >= 10 && strlen($s) <= 72;
}
