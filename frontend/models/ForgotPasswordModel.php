<?php

// Робота з базою даних для ForgotPasswordModel. HTML і форми обробляються в інших файлах.
class ForgotPasswordModel extends BaseModel
{
    // Рахуємо записи у базі через підготовлений запит.
    public function countUser(array $parameters = []): PDOStatement
    {
        return $this->query("SELECT COUNT(*) FROM User WHERE Email=?", $parameters);
    }

    // Видаляємо запис у базі через підготовлений запит.
    public function deletePasswordResets(array $parameters = []): PDOStatement
    {
        return $this->query("DELETE FROM PasswordResets WHERE Email=?", $parameters);
    }

    // Додаємо запис у базі через підготовлений запит.
    public function insertPasswordResets(array $parameters = []): PDOStatement
    {
        return $this->query(
            "INSERT INTO PasswordResets (Email,Token,Expiry) VALUES (?,?,DATE_ADD(NOW(),INTERVAL 1 HOUR))",
            $parameters
        );
    }
}
