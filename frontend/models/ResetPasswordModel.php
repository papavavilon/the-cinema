<?php

// Робота з базою даних для ResetPasswordModel. HTML і форми обробляються в інших файлах.
class ResetPasswordModel extends BaseModel
{
    // Читаємо записи у базі через підготовлений запит.
    public function fetchPasswordResets(array $parameters = []): PDOStatement
    {
        return $this->query("SELECT * FROM PasswordResets WHERE Token=? AND Expiry>NOW()", $parameters);
    }

    // Оновлюємо запис у базі через підготовлений запит.
    public function updateUser(array $parameters = []): PDOStatement
    {
        return $this->query("UPDATE User SET Password=? WHERE Email=?", $parameters);
    }

    // Видаляємо запис у базі через підготовлений запит.
    public function deletePasswordResets(array $parameters = []): PDOStatement
    {
        return $this->query("DELETE FROM PasswordResets WHERE Email=?", $parameters);
    }
}
