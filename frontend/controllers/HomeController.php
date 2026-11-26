<?php

// Готуємо дані сторінки та передаємо їх до шаблону.
class HomeController
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
        $model = new HomeModel($db);
        $featured = $model->featuredMovies([])->fetchAll();
        $hero = $featured[0] ?? $model->latestMovie([])->fetch();
        $new = $model->newMovies([])->fetchAll();
        $classics = $model->classicMovies([])->fetchAll();
        $latestNews = $model->fetchNews([]);
        $today = $model->today();
        $company = $model->company();

        // Передаємо підготовлені дані до шаблону сторінки.
        page_head("A better kind of movie night");
        require ROOT_PATH . "/frontend/views/home/content.php";
        page_foot();
    }
}
