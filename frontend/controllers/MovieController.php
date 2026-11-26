<?php

// Готуємо дані сторінки та передаємо їх до шаблону.
class MovieController
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
        $model = new MovieModel($db);
        $movie = movie($_GET["movie_id"] ?? 0);
        if (!$movie) {
            http_response_code(404);
            throw new RuntimeException("Film not found.");
        }
        $times = $model->showtimes($movie["Movie_ID"]);

        // Передаємо підготовлені дані до шаблону сторінки.
        page_head($movie["Title"]);
        require ROOT_PATH . "/frontend/views/movie/content.php";
        page_foot();
    }
}
