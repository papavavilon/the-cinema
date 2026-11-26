<?php

// Робота з базою даних для OverviewModel. HTML і форми обробляються в інших файлах.
class OverviewModel extends BaseModel
{
    // Читаємо записи у базі через підготовлений запит.
    public function fetchUser(array $parameters = []): PDOStatement
    {
        return $this->query("SELECT * FROM User WHERE User_ID=?", $parameters);
    }
}
