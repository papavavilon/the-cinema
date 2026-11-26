<?php

// Робота з базою даних для InvoiceModel. HTML і форми обробляються в інших файлах.
class InvoiceModel extends BaseModel
{
    // Читаємо записи у базі через підготовлений запит.
    public function fetchBooking(array $parameters = []): PDOStatement
    {
        return $this->query(
            "SELECT b.*,i.*,m.Title FROM Booking b JOIN Invoice i ON i.Invoice_ID=b.Invoice_ID JOIN Movie m ON " .
                "m.Movie_ID=b.Movie_ID WHERE i.Invoice_ID=?",
            $parameters
        );
    }

    // Читаємо записи у базі через підготовлений запит.
    public function fetchTicket(array $parameters = []): PDOStatement
    {
        return $this->query(
            "SELECT t.*,s.ShowDate,s.ShowTime,st.`Row`,st.SeatNumber,h.Name AS Hall,p.Type FROM Ticket t JOIN " .
                "Screening s ON s.Screening_ID=t.Screening_ID JOIN Seat st ON st.Seat_ID=t.Seat_ID JOIN CinemaHall h " .
                "ON h.CinemaHall_ID=s.CinemaHall_ID JOIN TicketPrice p ON p.Price_ID=t.Price_ID WHERE t.Booking_ID=?",
            $parameters
        );
    }
}
