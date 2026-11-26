<?php
// Працівник створює рахунок або відкриває вже створений. Повторний запит не додає дубль.
class StaffInvoiceAction
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
        if (empty($_SESSION["admin_id"])) {
            go("admin/login");
        }
        $model = new StaffInvoiceModel($this->db);
        $this->db->beginTransaction();
        $booking = $model->booking((int) ($_POST["id"] ?? 0));
        if (!$booking) {
            throw new RuntimeException("Booking not found.");
        }
        $invoiceId = (int) $booking["Invoice_ID"];
        if (!$invoiceId) {
            $invoiceId = $model->create((float) $booking["TotalPrice"]);
            $model->attach((int) $booking["Booking_ID"], $invoiceId);
        }
        $this->db->commit();
        go("invoice?invoice_id=" . $invoiceId);
    }
}
