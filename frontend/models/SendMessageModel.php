<?php

// Робота з базою даних для SendMessageModel. HTML і форми обробляються в інших файлах.
class SendMessageModel extends BaseModel
{
    // Додаємо запис у базі через підготовлений запит.
    public function insertContactMessages(array $parameters = []): PDOStatement
    {
        return $this->query(
            "INSERT INTO ContactMessages (Name,Email,Subject,Message,Submitted_At) VALUES (?,?,?,?,NOW())",
            $parameters
        );
    }
}
