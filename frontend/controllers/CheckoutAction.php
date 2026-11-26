<?php

// Обробляємо форму підтвердження бронювання.
class CheckoutAction
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
        $model = new CheckoutModel($db);
        // Блокуємо сеанс на час запису замовлення й повторно перевіряємо вільні місця.
        if (
            empty($_SESSION["selection"]) ||
            !hash_equals($_SESSION["booking_nonce"] ?? "", $_POST["nonce"] ?? "-")
        ) {
            throw new RuntimeException("This booking has already been completed or expired.");
        }
        $db->beginTransaction();
        $order = selection($_SESSION["selection"], true);
        $s = $order["screening"];
        [$couponId, $discount] = coupon(trim($_POST["coupon"] ?? ""), $order["total"]);
        $total = $order["total"] - $discount;
        $uid = $_SESSION["user_id"] ?? null;
        $gid = null;
        if (!$uid) {
            $email = trim($_POST["email"] ?? "");
            $first = trim($_POST["firstname"] ?? "");
            $last = trim($_POST["lastname"] ?? "");
            if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !$first || !$last) {
                throw new RuntimeException("Enter your name and email to continue as a guest.");
            }
            $model->insertGuestUser([$first, $last, $email, trim($_POST["phone"] ?? "")]);
            $gid = $db->lastInsertId();
        } else {
            $email = $model->fetchUser([$uid])->fetchColumn();
        }
        $model->insertInvoice([$total]);
        $invoice = $db->lastInsertId();
        $model->insertBooking([
            $s["Movie_ID"],
            $uid,
            $gid,
            count($order["seats"]),
            $total,
            $invoice,
            $couponId
        ]);
        $bid = $db->lastInsertId();
        $i = 0;
        foreach ($order["tickets"] as $t) {
            for ($j = 0; $j < $t["quantity"]; $j++) {
                $model->insertTicket([
                    $s["Screening_ID"],
                    $order["seats"][$i++]["Seat_ID"],
                    $t["price"]["Price_ID"],
                    $bid
                ]);
            }
        }
        outbox(
            $email,
            "thecinema · Booking #" . $bid,
            "Your demo booking for " .
                $s["Title"] .
                " on " .
                $s["ShowDate"] .
                " at " .
                $s["ShowTime"] .
                " is confirmed. Total: " .
                money($total) .
                ". No money was charged."
        );
        $db->commit();
        if (!$uid) {
            $_SESSION["guest_invoices"][$invoice] = true;
        }
        unset($_SESSION["selection"], $_SESSION["booking_nonce"]);
        try {
            (new MailService())->send(
                $email,
                "The Cinema · Booking #" . $bid,
                "Your booking for " . $s["Title"] . " is confirmed. Total: " . money($total)
            );
        } catch (Throwable $error) {
            error_log("Booking email delivery failed: " . $error->getMessage());
        }
        go("invoice?invoice_id=" . $invoice);
    }
}
