<?php

// Готуємо дані сторінки та передаємо їх до шаблону.
class ProfileController
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
        $model = new ProfileModel($db);
        if (empty($_SESSION["user_id"])) {
            go("user/login");
        }
        $user = $model->fetchUser([$_SESSION["user_id"]])->fetch();
        $bookings = $model->fetchBooking([$user["User_ID"]])->fetchAll();

        // Передаємо підготовлені дані до шаблону сторінки.
        page_head("My tickets");
        require ROOT_PATH . "/frontend/views/profile/content.php";
        page_foot();
    }
}
