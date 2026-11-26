<?php

// Робота з базою даних для AdminModel. HTML і форми обробляються в інших файлах.
class AdminModel extends BaseModel
{
    // Рахуємо записи у базі через підготовлений запит.
    public function countAdmin(array $parameters = []): PDOStatement
    {
        return $this->query("SELECT COUNT(*) FROM Admin", $parameters);
    }

    // Додаємо запис у базі через підготовлений запит.
    public function insertAdmin(array $parameters = []): PDOStatement
    {
        return $this->query("INSERT INTO Admin (Email,Password) VALUES (?,?)", $parameters);
    }

    // Видаляємо запис у базі через підготовлений запит.
    public function deleteRecords(array $parameters = [], $table = null, $pk = null): PDOStatement
    {
        return $this->query("DELETE FROM `$table` WHERE `$pk`=?", $parameters);
    }

    // Рахуємо записи у базі через підготовлений запит.
    public function countOverlappingScreenings(array $parameters = []): PDOStatement
    {
        return $this->query(
            "SELECT COUNT(*) FROM Screening a JOIN Screening b ON a.CinemaHall_ID=b.CinemaHall_ID AND " .
                "a.Screening_ID<>b.Screening_ID JOIN Movie m ON m.Movie_ID=b.Movie_ID WHERE a.Movie_ID=? AND " .
                "TIMESTAMP(a.ShowDate,a.ShowTime)<DATE_ADD(TIMESTAMP(b.ShowDate,b.ShowTime),INTERVAL " .
                "(IF(b.Movie_ID=?,TIME_TO_SEC(?),TIME_TO_SEC(m.Duration))+900) SECOND) AND " .
                "DATE_ADD(TIMESTAMP(a.ShowDate,a.ShowTime),INTERVAL (TIME_TO_SEC(?)+900) " .
                "SECOND)>TIMESTAMP(b.ShowDate,b.ShowTime)",
            $parameters
        );
    }

    // Рахуємо записи у базі через підготовлений запит.
    public function countTicket(array $parameters = []): PDOStatement
    {
        return $this->query("SELECT COUNT(*) FROM Ticket WHERE Screening_ID=?", $parameters);
    }

    // Читаємо записи у базі через підготовлений запит.
    public function fetchScreening(array $parameters = []): PDOStatement
    {
        return $this->query("SELECT * FROM Screening WHERE Screening_ID=?", $parameters);
    }

    // Оновлюємо запис у базі через підготовлений запит.
    public function updateRecords(
        array $parameters = [],
        $table = null,
        $cols = null,
        $pk = null
    ): PDOStatement {
        return $this->query(
            "UPDATE `$table` SET " .
                implode(
                    ",",
                    array_map(function ($c) {
                        return "`$c`=?";
                    }, $cols)
                ) .
                " WHERE `$pk`=?",
            $parameters
        );
    }

    // Додаємо запис у базі через підготовлений запит.
    public function insertRecords(array $parameters = [], $table = null, $cols = null): PDOStatement
    {
        return $this->query(
            "INSERT INTO `$table` (`" .
                implode("`,`", $cols) .
                "`) VALUES (" .
                implode(",", array_fill(0, count($cols), "?")) .
                ")",
            $parameters
        );
    }

    // Видаляємо запис у базі через підготовлений запит.
    public function deleteMedia(array $parameters = []): PDOStatement
    {
        return $this->query("DELETE FROM Media WHERE Movie_ID=? AND IsFeatured=?", $parameters);
    }

    // Додаємо запис у базі через підготовлений запит.
    public function insertMedia(array $parameters = []): PDOStatement
    {
        return $this->query(
            "INSERT INTO Media (FileName,IsFeatured,Format,Movie_ID) VALUES (?,?,?,?)",
            $parameters
        );
    }

    // Читаємо записи у базі через підготовлений запит.
    public function fetchContactMessages(array $parameters = []): PDOStatement
    {
        return $this->query("SELECT * FROM ContactMessages WHERE Message_ID=?", $parameters);
    }

    // Оновлюємо запис у базі через підготовлений запит.
    public function updateContactMessages(array $parameters = []): PDOStatement
    {
        return $this->query("UPDATE ContactMessages SET Reply=? WHERE Message_ID=?", $parameters);
    }

    // Оновлюємо запис у базі через підготовлений запит.
    public function lockBooking(array $parameters = []): PDOStatement
    {
        return $this->query("SELECT * FROM Booking WHERE Booking_ID=? FOR UPDATE", $parameters);
    }

    // Видаляємо запис у базі через підготовлений запит.
    public function deleteTicket(array $parameters = []): PDOStatement
    {
        return $this->query("DELETE FROM Ticket WHERE Booking_ID=?", $parameters);
    }

    // Оновлюємо запис у базі через підготовлений запит.
    public function cancelBooking(array $parameters = []): PDOStatement
    {
        return $this->query("UPDATE Booking SET PaymentStatus='Cancelled' WHERE Booking_ID=?", $parameters);
    }

    // Оновлюємо запис у базі через підготовлений запит.
    public function cancelInvoice(array $parameters = []): PDOStatement
    {
        return $this->query("UPDATE Invoice SET InvoiceStatus='Cancelled' WHERE Invoice_ID=?", $parameters);
    }

    // Читаємо записи у базі через підготовлений запит.
    public function findRecord(array $parameters = [], $sec = null): PDOStatement
    {
        return $this->query(
            "SELECT * FROM `" . $sec["table"] . "` WHERE `" . $sec["pk"] . "`=?",
            $parameters
        );
    }

    // Читаємо записи у базі через підготовлений запит.
    public function listRecords(array $parameters = [], $sec = null): PDOStatement
    {
        return $this->query(
            "SELECT * FROM `" . $sec["table"] . "` ORDER BY `" . $sec["pk"] . "` DESC",
            $parameters
        );
    }

    // Читаємо записи у базі через підготовлений запит.
    public function listOptions(array $parameters = [], $table = null): PDOStatement
    {
        return $this->query("SELECT * FROM " . $table, $parameters);
    }

    // Читаємо записи у базі через підготовлений запит.
    public function listMessages(array $parameters = []): PDOStatement
    {
        return $this->query("SELECT * FROM ContactMessages ORDER BY Submitted_At DESC", $parameters);
    }

    // Читаємо записи у базі через підготовлений запит.
    public function fetchMailOutbox(array $parameters = []): PDOStatement
    {
        return $this->query("SELECT * FROM MailOutbox ORDER BY ID DESC LIMIT 100", $parameters);
    }

    // Читаємо записи у базі через підготовлений запит.
    public function fetchBooking(array $parameters = []): PDOStatement
    {
        return $this->query(
            "SELECT b.*,m.Title FROM Booking b JOIN Movie m ON m.Movie_ID=b.Movie_ID ORDER BY Booking_ID DESC",
            $parameters
        );
    }

    // Рахуємо записи у базі через підготовлений запит.
    public function countRecords(array $parameters = [], $t = null): PDOStatement
    {
        return $this->query("SELECT COUNT(*) FROM " . $t, $parameters);
    }
}
