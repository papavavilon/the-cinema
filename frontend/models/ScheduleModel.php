<?php

// Робота з базою даних для ScheduleModel. HTML і форми обробляються в інших файлах.
class ScheduleModel extends BaseModel
{
    // Читаємо записи у базі через підготовлений запит.
    public function fetchMovie(array $parameters = []): PDOStatement
    {
        return $this->query("SELECT Movie_ID FROM Movie ORDER BY (Year>=2025) DESC,Movie_ID", $parameters);
    }

    // Читаємо записи у базі через підготовлений запит.
    public function fetchCinemaHall(array $parameters = []): PDOStatement
    {
        return $this->query("SELECT CinemaHall_ID FROM CinemaHall ORDER BY CinemaHall_ID", $parameters);
    }

    // Рахуємо записи у базі через підготовлений запит.
    public function countScreening(array $parameters = []): PDOStatement
    {
        return $this->query(
            "SELECT COUNT(*) FROM Screening WHERE CinemaHall_ID=? AND ShowDate=? AND ShowTime=?",
            $parameters
        );
    }

    // Додаємо запис у базі через підготовлений запит.
    public function insertScreening(array $parameters = []): PDOStatement
    {
        return $this->query(
            "INSERT INTO Screening (ShowDate,ShowTime,CinemaHall_ID,Movie_ID) VALUES (?,?,?,?)",
            $parameters
        );
    }
}
