<?php

// Робота з базою даних для CheckoutModel. HTML і форми обробляються в інших файлах.
class CheckoutModel extends BaseModel
{
    // Додаємо запис у базі через підготовлений запит.
    public function insertGuestUser(array $parameters = []): PDOStatement
    {
        return $this->query(
            "INSERT INTO GuestUser (Firstname,Lastname,Email,TelephoneNumber) VALUES (?,?,?,?)",
            $parameters
        );
    }

    // Читаємо записи у базі через підготовлений запит.
    public function fetchUser(array $parameters = []): PDOStatement
    {
        return $this->query("SELECT Email FROM User WHERE User_ID=?", $parameters);
    }

    // Додаємо запис у базі через підготовлений запит.
    public function insertInvoice(array $parameters = []): PDOStatement
    {
        return $this->query(
            "INSERT INTO Invoice (InvoiceDate,TotalAmount,InvoiceStatus) VALUES (CURDATE(),?,'Demo — no charge')",
            $parameters
        );
    }

    // Додаємо запис у базі через підготовлений запит.
    public function insertBooking(array $parameters = []): PDOStatement
    {
        return $this->query(
            "INSERT INTO Booking (Movie_ID,User_ID,GuestUser_ID,BookingDate,NumberOfTickets,PaymentStatus,
TotalPrice,Invoice_ID,Coupon_ID) VALUES (?,?,?,CURDATE(),?,'Demo confirmed',?,?,?)",
            $parameters
        );
    }

    // Додаємо запис у базі через підготовлений запит.
    public function insertTicket(array $parameters = []): PDOStatement
    {
        return $this->query(
            "INSERT INTO Ticket (Screening_ID,Seat_ID,Price_ID,Booking_ID) VALUES (?,?,?,?)",
            $parameters
        );
    }
}
