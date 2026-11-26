<?php
// Рахунок створюємо для бронювання, заблокованого в межах транзакції.
class StaffInvoiceModel extends BaseModel
{
    public function booking(int $id)
    {
        return $this->query("SELECT * FROM Booking WHERE Booking_ID=? FOR UPDATE", [$id])->fetch();
    }
    public function create(float $total): int
    {
        $this->query(
            "INSERT INTO Invoice (InvoiceDate,TotalAmount,InvoiceStatus) VALUES (CURDATE(),?,'Demo — no charge')",
            [$total]
        );
        return (int) $this->db->lastInsertId();
    }
    public function attach(int $bookingId, int $invoiceId): void
    {
        $this->query("UPDATE Booking SET Invoice_ID=? WHERE Booking_ID=?", [$invoiceId, $bookingId]);
    }
}
