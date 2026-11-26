<?php

// Робота з базою даних для NewsModel. HTML і форми обробляються в інших файлах.
class NewsModel extends BaseModel
{
    // Читаємо записи у базі через підготовлений запит.
    public function fetchNews(array $parameters = []): PDOStatement
    {
        return $this->query("SELECT * FROM News ORDER BY DatePosted DESC", $parameters);
    }
}
