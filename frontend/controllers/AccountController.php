<?php

// Готуємо дані сторінки та передаємо їх до шаблону.
class AccountController
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
        $model = new AccountModel($db);
        $register = $path === "user/new_user";
        $forgot = $path === "user/forgot-password";
        $reset = $path === "user/reset-password";
        $title = $register
            ? "Your seat is waiting."
            : ($forgot
                ? "Let’s get you back in."
                : ($reset
                    ? "A fresh start."
                    : "Welcome back."));

        // Передаємо підготовлені дані до шаблону сторінки.
        page_head($title);
        require ROOT_PATH . "/frontend/views/account/content.php";
        page_foot();
    }
}
