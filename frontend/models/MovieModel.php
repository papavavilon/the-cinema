<?php

// Робота з базою даних для MovieModel. HTML і форми обробляються в інших файлах.
class MovieModel extends BaseModel
{
    public static function selectSql()
    {
        return "SELECT m.*,g.Name AS Genre,v.Format,v.AdditionalFee,(SELECT FileName FROM Media WHERE " .
            "Movie_ID=m.Movie_ID AND IsFeatured=1 ORDER BY Media_ID LIMIT 1) AS Poster,(SELECT FileName FROM " .
            "Media WHERE Movie_ID=m.Movie_ID AND IsFeatured=0 ORDER BY Media_ID LIMIT 1) AS Backdrop FROM Movie " .
            "m LEFT JOIN Genre g ON g.Genre_ID=m.Genre_ID LEFT JOIN Version v ON v.Version_ID=m.Version_ID";
    }

    // Читаємо записи у базі через підготовлений запит.
    public function findMovie(array $parameters = []): PDOStatement
    {
        return $this->query(MovieModel::selectSql() . " WHERE m.Movie_ID=?", $parameters);
    }

    // Повертаємо найближчі сеанси обраного фільму.
    public function showtimes(int $movieId): array
    {
        return $this->query(
            'SELECT s.*, h.Name AS Hall FROM Screening s JOIN CinemaHall h ON h.CinemaHall_ID=s.CinemaHall_ID
 WHERE Movie_ID=? AND TIMESTAMP(ShowDate,ShowTime)>NOW() AND ShowDate<DATE_ADD(CURDATE(),INTERVAL 14 DAY)
 ORDER BY ShowDate,ShowTime',
            [$movieId]
        )->fetchAll();
    }
}
