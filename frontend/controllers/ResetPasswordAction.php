<?php

// Обробляємо форму нового пароля.
class ResetPasswordAction
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
        $model = new ResetPasswordModel($db);
        $reset = $model->fetchPasswordResets([hash("sha256", $_POST["token"] ?? "")])->fetch();
        if (!$reset || !password_ok($_POST["password"] ?? "")) {
            throw new RuntimeException(
                "The reset link expired, or the password is shorter than 10 characters."
            );
        }
        $model->updateUser([password_hash($_POST["password"], PASSWORD_DEFAULT), $reset["Email"]]);
        $model->deletePasswordResets([$reset["Email"]]);
        flash("Password updated. You can sign in.");
        go("user/login");
    }
}
