<?php

// Робота з базою даних для RegisterModel. HTML і форми обробляються в інших файлах.
class RegisterModel extends BaseModel
{
    // Рахуємо записи у базі через підготовлений запит.
    public function countUser(array $parameters = []): PDOStatement
    {
        return $this->query("SELECT COUNT(*) FROM User WHERE Email=? OR Name=?", $parameters);
    }

    // Додаємо запис у базі через підготовлений запит.
    public function insertUser(array $parameters = []): PDOStatement
    {
        return $this->query(
            "INSERT INTO User (Name,Email,TelephoneNumber,Password) VALUES (?,?,?,?)",
            $parameters
        );
    }
}
