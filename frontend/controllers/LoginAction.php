<?php

// Обробляємо форму входу.
class LoginAction
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
        $model = new LoginModel($db);
        rate_limit("login");
        $admin = $path === "admin/login";
        $email = trim($_POST["email"] ?? "");
        $u = $admin ? $model->fetchAdmin([$email])->fetch() : $model->fetchUser([$email, $email])->fetch();
        if (!$u || !password_verify($_POST["password"] ?? "", $u["Password"])) {
            throw new RuntimeException("Email or password is incorrect.");
        }
        session_regenerate_id(true);
        if ($admin) {
            $_SESSION["admin_id"] = $u["Admin_ID"];
            go("admin/dashboard");
        }
        $_SESSION["user_id"] = $u["User_ID"];
        unset($_SESSION["guest_user_id"]);
        go(isset($_SESSION["selection"]) ? "overview" : "user/profiles");
    }
}
