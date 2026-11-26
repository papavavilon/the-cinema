<?php

// Робота з базою даних для MailModel. HTML і форми обробляються в інших файлах.
class MailModel extends BaseModel
{
    // Додаємо запис у базі через підготовлений запит.
    public function insertMailOutbox(array $parameters = []): PDOStatement
    {
        return $this->query("INSERT INTO MailOutbox (Recipient,Subject,Body) VALUES (?,?,?)", $parameters);
    }
}
