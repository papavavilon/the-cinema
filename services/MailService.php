<?php
// Надсилаємо листи через SMTP за допомогою PHPMailer, як у референсі.
class MailService
{
    private array $settings;
    public function __construct()
    {
        $this->settings = require ROOT_PATH . "/config/mail.php";
    }
    public function enabled(): bool
    {
        return (bool) $this->settings["enabled"];
    }
    public function owner(): string
    {
        return $this->settings["owner_email"];
    }
    public function baseUrl(): string
    {
        return rtrim($this->settings["base_url"], "/");
    }
    public function send(string $recipient, string $subject, string $body, ?string $replyTo = null): bool
    {
        if (!$this->enabled()) {
            return false;
        }
        require_once ROOT_PATH . "/vendor/phpmailer/phpmailer/src/Exception.php";
        require_once ROOT_PATH . "/vendor/phpmailer/phpmailer/src/PHPMailer.php";
        require_once ROOT_PATH . "/vendor/phpmailer/phpmailer/src/SMTP.php";
        $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = $this->settings["host"];
        $mail->Port = (int) $this->settings["port"];
        $mail->SMTPAuth = true;
        $mail->Username = $this->settings["username"];
        $mail->Password = $this->settings["password"];
        $mail->SMTPSecure = $this->settings["encryption"];
        $mail->CharSet = "UTF-8";
        $mail->Timeout = 10;
        $mail->setFrom($this->settings["from_email"], $this->settings["from_name"]);
        $mail->addAddress($recipient);
        if ($replyTo) {
            $mail->addReplyTo($replyTo);
        }
        $mail->Subject = $subject;
        $mail->Body = $body;
        return $mail->send();
    }
}
