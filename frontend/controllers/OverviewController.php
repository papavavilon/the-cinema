<?php

// Готуємо дані сторінки та передаємо їх до шаблону.
class OverviewController
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
        $model = new OverviewModel($db);
        if (empty($_SESSION["selection"])) {
            go("movies");
        }
        $order = selection($_SESSION["selection"]);
        $screening = $order["screening"];
        $account = empty($_SESSION["user_id"]) ? null : $model->fetchUser([$_SESSION["user_id"]])->fetch();

        // Передаємо підготовлені дані до шаблону сторінки.
        page_head("Your booking");
        require ROOT_PATH . "/frontend/views/overview/content.php";
        page_foot();
    }
}
