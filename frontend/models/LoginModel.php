<?php

// Робота з базою даних для LoginModel. HTML і форми обробляються в інших файлах.
class LoginModel extends BaseModel
{
    // Читаємо записи у базі через підготовлений запит.
    public function fetchAdmin(array $parameters = []): PDOStatement
    {
        return $this->query("SELECT * FROM Admin WHERE Email=?", $parameters);
    }

    // Читаємо записи у базі через підготовлений запит.
    public function fetchUser(array $parameters = []): PDOStatement
    {
        return $this->query("SELECT * FROM User WHERE Email=? OR Name=?", $parameters);
    }
}
