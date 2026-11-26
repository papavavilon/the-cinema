<?php

// Робота з базою даних для AccountModel. HTML і форми обробляються в інших файлах.
class AccountModel extends BaseModel
{
    // Рахуємо записи у базі через підготовлений запит.
    public function countAuthAttempts(array $parameters = []): PDOStatement
    {
        return $this->query(
            "SELECT COUNT(*) FROM AuthAttempts WHERE IP=? AND Action=? AND AttemptedAt>DATE_SUB(NOW(),INTERVAL 10 MINUTE)",
            $parameters
        );
    }

    // Додаємо запис у базі через підготовлений запит.
    public function insertAuthAttempts(array $parameters = []): PDOStatement
    {
        return $this->query("INSERT INTO AuthAttempts (IP,Action) VALUES (?,?)", $parameters);
    }
}
