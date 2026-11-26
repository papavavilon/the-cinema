<?php

// Робота з базою даних для ContactModel. HTML і форми обробляються в інших файлах.
class ContactModel extends BaseModel
{
    // Читаємо записи у базі через підготовлений запит.
    public function fetchCompany(array $parameters = []): PDOStatement
    {
        return $this->query("SELECT * FROM Company LIMIT 1", $parameters);
    }
}
