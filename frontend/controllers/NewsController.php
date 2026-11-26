<?php

// Готуємо дані сторінки та передаємо їх до шаблону.
class NewsController
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
        $model = new NewsModel($db);
        $news = $model->fetchNews([]);

        // Передаємо підготовлені дані до шаблону сторінки.
        page_head("The Cinema Journal");
        require ROOT_PATH . "/frontend/views/news/content.php";
        page_foot();
    }
}
