<?php

// Робота з базою даних для UpdateProfileModel. HTML і форми обробляються в інших файлах.
class UpdateProfileModel extends BaseModel
{
    // Рахуємо записи у базі через підготовлений запит.
    public function countUser(array $parameters = []): PDOStatement
    {
        return $this->query("SELECT COUNT(*) FROM User WHERE Email=? AND User_ID<>?", $parameters);
    }

    // Оновлюємо запис у базі через підготовлений запит.
    public function updateUser(array $parameters = []): PDOStatement
    {
        return $this->query("UPDATE User SET Email=?,TelephoneNumber=? WHERE User_ID=?", $parameters);
    }
}
