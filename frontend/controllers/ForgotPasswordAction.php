<?php

// Обробляємо форму відновлення пароля.
class ForgotPasswordAction
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
        $model = new ForgotPasswordModel($db);
        rate_limit("reset");
        $email = trim($_POST["email"] ?? "");
        if ($model->countUser([$email])->fetchColumn()) {
            $raw = bin2hex(random_bytes(32));
            $model->deletePasswordResets([$email]);
            $model->insertPasswordResets([$email, hash("sha256", $raw)]);
            outbox(
                $email,
                "thecinema · Reset your password",
                "Open this link within one hour: " .
                    (new MailService())->baseUrl() .
                    "/user/reset-password?token=" .
                    $raw
            );
        }
        flash(
            (new MailService())->enabled()
                ? "If the account exists, password reset instructions have been requested."
                : "If the account exists, a reset message is available in the local mailbox."
        );
        go("user/forgot-password");
    }
}
