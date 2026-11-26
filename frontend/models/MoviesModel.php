<?php

// Робота з базою даних для MoviesModel. HTML і форми обробляються в інших файлах.
class MoviesModel extends BaseModel
{
    // Шукаємо фільми за назвою, колекцією та датою сеансу.
    public function search(string $term, string $collection, string $date): array
    {
        $sql = MovieModel::selectSql() . " WHERE 1=1";
        $parameters = [];
        if ($term !== "") {
            $sql .= " AND m.Title LIKE ?";
            $parameters[] = "%" . $term . "%";
        }
        if ($collection === "new") {
            $sql .= " AND m.Year>=2025";
        }
        if ($collection === "classics") {
            $sql .= " AND m.Year<2025";
        }
        if ($date !== "") {
            $sql .=
                " AND EXISTS(SELECT 1 FROM Screening s WHERE s.Movie_ID=m.Movie_ID AND s.ShowDate=? AND " .
                "TIMESTAMP(s.ShowDate,s.ShowTime)>NOW())";
            $parameters[] = $date;
        }
        return $this->query($sql . " ORDER BY m.Year DESC,m.Title", $parameters)->fetchAll();
    }
}
