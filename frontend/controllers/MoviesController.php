<?php

// Готуємо дані сторінки та передаємо їх до шаблону.
class MoviesController
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
        $model = new MoviesModel($db);
        $term = trim($_GET["q"] ?? "");
        $collection = $_GET["collection"] ?? "";
        $date = $_GET["date"] ?? "";
        $movies = $model->search($term, $collection, $date);

        // Передаємо підготовлені дані до шаблону сторінки.
        page_head("Films & times");
        require ROOT_PATH . "/frontend/views/movies/content.php";
        page_foot();
    }
}
