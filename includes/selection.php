<?php

// Допоміжна перевірка вибраних квитків і місць.
function selection($data, $lock = false)
{
    global $db;
    $model = new BookingModel($db);
    $s = screening($data["screening_id"] ?? 0, $lock);
    if (!future_screening($s)) {
        throw new RuntimeException("This screening is no longer available. Choose another time.");
    }
    $seats = array_values(array_unique(array_map("intval", (array) ($data["seats"] ?? []))));
    if (count($seats) < 1 || count($seats) > 5) {
        throw new RuntimeException("Select between 1 and 5 seats.");
    }
    $types = (array) ($data["tickets"] ?? []);
    $tickets = [];
    $total = 0;
    $count = 0;
    foreach ($model->fetchTicketPrice([$s["ShowDate"], $s["ShowDate"]])->fetchAll() as $p) {
        $n = filter_var($types[$p["Price_ID"]] ?? 0, FILTER_VALIDATE_INT);
        if ($n === false || $n < 0 || $n > 5) {
            throw new RuntimeException("Invalid ticket quantity.");
        }
        if ($n) {
            $tickets[] = ["price" => $p, "quantity" => $n];
            $count += $n;
            $total += $n * ((float) $p["Price"] + (float) $s["AdditionalFee"]);
        }
    }
    if ($count !== count($seats)) {
        throw new RuntimeException("Choose one seat for each ticket.");
    }
    $rows = [];
    foreach ($seats as $id) {
        $seat = $model->fetchSeat([$id, $s["CinemaHall_ID"]])->fetch();
        if (!$seat) {
            throw new RuntimeException("One of these seats does not belong to this hall.");
        }
        if ($model->countTicket([$s["Screening_ID"], $id])->fetchColumn()) {
            throw new RuntimeException("A selected seat has just been booked. Please choose another.");
        }
        $rows[] = $seat;
    }
    return ["screening" => $s, "seats" => $rows, "tickets" => $tickets, "total" => $total];
}
