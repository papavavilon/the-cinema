<?php

// Обробляємо форму вибору місць.
class SelectSeatsAction
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

        $data = [
            "screening_id" => (int) ($_POST["screening_id"] ?? 0),
            "seats" => $_POST["seats"] ?? [],
            "tickets" => $_POST["tickets"] ?? []
        ];
        selection($data);
        $_SESSION["selection"] = $data;
        $_SESSION["booking_nonce"] = bin2hex(random_bytes(24));
        go("overview");
    }
}
