<?php

// Готуємо дані сторінки та передаємо їх до шаблону.
class SeatController
{
    private PDO $db;
    // Отримуємо підключення до бази для цього контролера.
    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    // Перевіряємо запит, готуємо дані та обираємо наступну сторінку.
    public function handle(string $path): void
    {
        $db = $this->db;
        $model = new SeatModel($db);
        $screening = screening($_GET["screening_id"] ?? ($_SESSION["selection"]["screening_id"] ?? 0));
        if (!future_screening($screening)) {
            throw new RuntimeException("Choose an upcoming screening from a film page.");
        }
        $prices = $model->fetchTicketPrice([$screening["ShowDate"], $screening["ShowDate"]])->fetchAll();
        $seats = $model->fetchSeat([$screening["CinemaHall_ID"]])->fetchAll();
        $sold = $model->fetchTicket([$screening["Screening_ID"]])->fetchAll(PDO::FETCH_COLUMN);

        // Розкладаємо місця за рядами, щоб шаблон тільки показував готові дані.
        $seatRows = [];
        foreach ($seats as $seat) {
            $seatRows[$seat["Row"]][] = $seat;
        }

        // Передаємо підготовлені дані до шаблону сторінки.
        page_head("Choose your seats");
        require ROOT_PATH . "/frontend/views/seat/content.php";
        page_foot();
    }
}
