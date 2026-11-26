<?php

// Готуємо дані сторінки та передаємо їх до шаблону.
class ContactController
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
        $model = new ContactModel($db);
        $company = $model->fetchCompany([])->fetch();

        // Передаємо підготовлені дані до шаблону сторінки.
        page_head("Contact");
        require ROOT_PATH . "/frontend/views/contact/content.php";
        page_foot();
    }
}
