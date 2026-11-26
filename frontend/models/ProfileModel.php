<?php

// Робота з базою даних для ProfileModel. HTML і форми обробляються в інших файлах.
class ProfileModel extends BaseModel
{
    // Читаємо записи у базі через підготовлений запит.
    public function fetchUser(array $parameters = []): PDOStatement
    {
        return $this->query("SELECT * FROM User WHERE User_ID=?", $parameters);
    }

    // Читаємо записи у базі через підготовлений запит.
    public function fetchBooking(array $parameters = []): PDOStatement
    {
        return $this->query(
            "SELECT b.*,m.Title FROM Booking b JOIN Movie m ON m.Movie_ID=b.Movie_ID WHERE User_ID=? ORDER BY " .
                "Booking_ID DESC",
            $parameters
        );
    }
}
