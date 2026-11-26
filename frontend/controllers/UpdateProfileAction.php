<?php

// Обробляємо форму профілю.
class UpdateProfileAction
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
        $model = new UpdateProfileModel($db);
        if (empty($_SESSION["user_id"])) {
            go("user/login");
        }
        $email = trim($_POST["email"] ?? "");
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new RuntimeException("Enter a valid email.");
        }
        if ($model->countUser([$email, $_SESSION["user_id"]])->fetchColumn()) {
            throw new RuntimeException("This email is already in use.");
        }
        $model->updateUser([$email, trim($_POST["phone"] ?? ""), $_SESSION["user_id"]]);
        flash("Your details are saved.");
        go("user/profiles");
    }
}
