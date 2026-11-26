<?php

// Робота з базою даних для HomeModel. HTML і форми обробляються в інших файлах.
class HomeModel extends BaseModel
{
    // Читаємо записи у базі через підготовлений запит.
    public function featuredMovies(array $parameters = []): PDOStatement
    {
        return $this->query(
            MovieModel::selectSql() .
                " JOIN LandingMovies lm ON lm.Movie_ID=m.Movie_ID ORDER BY lm.DisplayOrder,lm.LandingMovie_ID LIMIT 3",
            $parameters
        );
    }

    // Читаємо записи у базі через підготовлений запит.
    public function latestMovie(array $parameters = []): PDOStatement
    {
        return $this->query(MovieModel::selectSql() . " ORDER BY m.Year DESC LIMIT 1", $parameters);
    }

    // Читаємо записи у базі через підготовлений запит.
    public function newMovies(array $parameters = []): PDOStatement
    {
        return $this->query(
            MovieModel::selectSql() . " WHERE m.Year>=2025 ORDER BY m.Year DESC,m.Movie_ID LIMIT 8",
            $parameters
        );
    }

    // Читаємо записи у базі через підготовлений запит.
    public function classicMovies(array $parameters = []): PDOStatement
    {
        return $this->query(
            MovieModel::selectSql() .
                " WHERE m.Year<2025 ORDER BY FIELD(m.Movie_ID,1,8,23) DESC,m.Rating DESC LIMIT 4",
            $parameters
        );
    }

    // Читаємо записи у базі через підготовлений запит.
    public function fetchNews(array $parameters = []): PDOStatement
    {
        return $this->query("SELECT * FROM News ORDER BY DatePosted DESC LIMIT 3", $parameters);
    }

    // Сеанси на сьогодні беремо з бази, разом із назвою фільму та залу.
    public function today(): array
    {
        return $this->query(
            'SELECT s.*, m.Title, h.Name AS Hall FROM Screening s
 JOIN Movie m ON m.Movie_ID=s.Movie_ID JOIN CinemaHall h ON h.CinemaHall_ID=s.CinemaHall_ID
 WHERE s.ShowDate=CURDATE() ORDER BY s.ShowTime,h.Name'
        )->fetchAll();
    }
    // Опис кінотеатру редагується через адмінпанель.
    public function company(): array
    {
        return $this->query("SELECT * FROM Company LIMIT 1")->fetch() ?: [];
    }
}
