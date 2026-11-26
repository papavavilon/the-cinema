<?php

// Готуємо дані сторінки та передаємо їх до шаблону.
class InvoiceController
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
        $model = new InvoiceModel($db);
        $id = (int) ($_GET["invoice_id"] ?? 0);
        $booking = $model->fetchBooking([$id])->fetch();
        if (
            !$booking ||
            !(
                !empty($_SESSION["admin_id"]) ||
                (!empty($_SESSION["user_id"]) && $booking["User_ID"] == $_SESSION["user_id"]) ||
                !empty($_SESSION["guest_invoices"][$id])
            )
        ) {
            throw new RuntimeException("Sign in with the booking account to view this confirmation.");
        }
        $tickets = $model->fetchTicket([$booking["Booking_ID"]])->fetchAll();

        // Передаємо підготовлені дані до шаблону сторінки.
        page_head("Booking confirmation");
        require ROOT_PATH . "/frontend/views/invoice/content.php";
        page_foot();
    }
}
