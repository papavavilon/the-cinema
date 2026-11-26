<?php

// Робота з базою даних для BookingModel. HTML і форми обробляються в інших файлах.
class BookingModel extends BaseModel
{
    // Оновлюємо запис у базі через підготовлений запит.
    public function findScreening(array $parameters = [], $lock = null): PDOStatement
    {
        return $this->query(
            "SELECT s.*,m.Title,m.Duration,m.AgeLimit,m.Version_ID,v.Format,v.AdditionalFee,h.Name AS Hall FROM " .
                "Screening s JOIN Movie m ON m.Movie_ID=s.Movie_ID JOIN CinemaHall h ON " .
                "h.CinemaHall_ID=s.CinemaHall_ID LEFT JOIN Version v ON v.Version_ID=m.Version_ID WHERE " .
                "s.Screening_ID=?" .
                ($lock ? " FOR UPDATE" : ""),
            $parameters
        );
    }

    // Читаємо записи у базі через підготовлений запит.
    public function fetchTicketPrice(array $parameters = []): PDOStatement
    {
        return $this->query(
            "SELECT * FROM TicketPrice WHERE (ValidFrom IS NULL OR ValidFrom<=?) AND (ValidTo IS NULL OR " .
                "ValidTo>=?) ORDER BY Price_ID",
            $parameters
        );
    }

    // Читаємо записи у базі через підготовлений запит.
    public function fetchSeat(array $parameters = []): PDOStatement
    {
        return $this->query("SELECT * FROM Seat WHERE Seat_ID=? AND CinemaHall_ID=?", $parameters);
    }

    // Рахуємо записи у базі через підготовлений запит.
    public function countTicket(array $parameters = []): PDOStatement
    {
        return $this->query("SELECT COUNT(*) FROM Ticket WHERE Screening_ID=? AND Seat_ID=?", $parameters);
    }

    // Читаємо записи у базі через підготовлений запит.
    public function fetchCoupon(array $parameters = []): PDOStatement
    {
        return $this->query("SELECT * FROM Coupon WHERE CouponCode=? AND ExpireDate>=CURDATE()", $parameters);
    }
}
