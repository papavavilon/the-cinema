<?php

// Робота з базою даних для SeatModel. HTML і форми обробляються в інших файлах.
class SeatModel extends BaseModel
{
    // Читаємо записи у базі через підготовлений запит.
    public function fetchTicketPrice(array $parameters = []): PDOStatement
    {
        return $this->query(
            "SELECT * FROM TicketPrice WHERE (ValidFrom IS NULL OR ValidFrom<=?) AND (ValidTo IS NULL OR ValidTo>=?)",
            $parameters
        );
    }

    // Читаємо записи у базі через підготовлений запит.
    public function fetchSeat(array $parameters = []): PDOStatement
    {
        return $this->query(
            "SELECT * FROM Seat WHERE CinemaHall_ID=? ORDER BY `Row`,SeatNumber",
            $parameters
        );
    }

    // Читаємо записи у базі через підготовлений запит.
    public function fetchTicket(array $parameters = []): PDOStatement
    {
        return $this->query("SELECT Seat_ID FROM Ticket WHERE Screening_ID=?", $parameters);
    }
}
