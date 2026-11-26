<?php

// Обробляємо форму виходу.
class LogoutAction
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

        unset($_SESSION["user_id"], $_SESSION["guest_user_id"]);
        session_regenerate_id(true);
        go();
    }
}
