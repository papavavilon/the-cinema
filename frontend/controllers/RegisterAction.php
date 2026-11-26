<?php

// Обробляємо форму реєстрації.
class RegisterAction
{
    private PDO $db;
    // Отримуємо підключення до бази для цього контролера.
    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    // Перевіряємо запит, готуємо дані та обираємо наступну сторінку.
    public function handle(string $path): void
    {
        $db = $this->db;
        $model = new RegisterModel($db);
        rate_limit("register");
        $name = trim($_POST["name"] ?? "");
        $email = trim($_POST["email"] ?? "");
        $pass = $_POST["password"] ?? "";
        if (
            !preg_match('/^[a-zA-Z0-9_]{3,30}$/', $name) ||
            !filter_var($email, FILTER_VALIDATE_EMAIL) ||
            !password_ok($pass)
        ) {
            throw new RuntimeException(
                "Use a username of 3–30 letters/numbers and a password of 10–72 characters. Enter a valid email."
            );
        }
        if ($model->countUser([$email, $name])->fetchColumn()) {
            throw new RuntimeException("That username or email is already registered.");
        }
        $model->insertUser([
            $name,
            $email,
            trim($_POST["phone"] ?? ""),
            password_hash($pass, PASSWORD_DEFAULT)
        ]);
        $_SESSION["user_id"] = $db->lastInsertId();
        session_regenerate_id(true);
        unset($_SESSION["guest_user_id"]);
        go(isset($_SESSION["selection"]) ? "overview" : "user/profiles");
    }
}
