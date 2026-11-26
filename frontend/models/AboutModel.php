<?php

// Робота з базою даних для AboutModel. HTML і форми обробляються в інших файлах.
class AboutModel extends BaseModel
{
    // Читаємо записи у базі через підготовлений запит.
    public function fetchCompany(array $parameters = []): PDOStatement
    {
        return $this->query("SELECT * FROM Company LIMIT 1", $parameters);
    }

    // Читаємо інформацію про кінотеатр для сторінки та підвалу.
    public function company(): array
    {
        return $this->fetchCompany()->fetch() ?: [];
    }
    // Показуємо всі зали, зокрема зали без запланованих сеансів.
    public function halls(): array
    {
        return $this->query("SELECT * FROM CinemaHall ORDER BY CinemaHall_ID")->fetchAll();
    }
}
