<?php

// Захищаємо форми від надсилання з чужого сайту.
function token()
{
    if (empty($_SESSION["csrf"])) {
        $_SESSION["csrf"] = bin2hex(random_bytes(32));
    }
    return $_SESSION["csrf"];
}

function csrf()
{
    echo '<input type="hidden" name="csrf" value="' . token() . '">';
}

function check_csrf()
{
    if (!hash_equals(token(), (string) ($_POST["csrf"] ?? ""))) {
        throw new RuntimeException("This form expired. Reload the page and try again.");
    }
}
