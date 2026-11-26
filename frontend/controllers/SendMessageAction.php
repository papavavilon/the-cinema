<?php

// Обробляємо форму зв’язку.
class SendMessageAction
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
        $model = new SendMessageModel($db);
        rate_limit("contact");
        foreach (["name", "subject", "message"] as $f) {
            if (!trim($_POST[$f] ?? "")) {
                throw new RuntimeException("Please complete all fields.");
            }
        }
        if (!filter_var($_POST["email"] ?? "", FILTER_VALIDATE_EMAIL)) {
            throw new RuntimeException("Enter a valid email.");
        }
        $model->insertContactMessages([
            trim($_POST["name"]),
            trim($_POST["email"]),
            trim($_POST["subject"]),
            trim($_POST["message"])
        ]);
        $mailer = new MailService();
        $notice = "Thank you. Your message has been saved for our cinema team.";
        if ($mailer->enabled()) {
            try {
                $mailer->send(
                    $mailer->owner(),
                    "The Cinema · " . trim($_POST["subject"]),
                    trim($_POST["message"]),
                    trim($_POST["email"])
                );
                $notice = "Thank you. Your message has been sent to our cinema team.";
            } catch (Throwable $error) {
                error_log("Contact email delivery failed: " . $error->getMessage());
            }
        }
        flash($notice);
        go("contact");
    }
}
