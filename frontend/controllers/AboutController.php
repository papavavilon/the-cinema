<?php

// Готуємо дані сторінки та передаємо їх до шаблону.
class AboutController
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
        $model = new AboutModel($db);
        $company = $model->fetchCompany([])->fetch();
        $halls = $model->halls();

        // Передаємо підготовлені дані до шаблону сторінки.
        page_head("Our cinema");
        require ROOT_PATH . "/frontend/views/about/content.php";
        page_foot();
    }
}
