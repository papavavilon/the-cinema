<?php
/* Показуємо рахунок і квитки. */ ?>
<main id="main" class="wrap narrow section">
    <?php heading(
        "03 / CONFIRMATION",
        $booking["PaymentStatus"] === "Cancelled" ? "Booking cancelled." : "You’re in.",
        $booking["PaymentStatus"] === "Cancelled"
            ? "These seats have been released."
            : "Your demo booking is confirmed. No payment has been taken."); ?>

    <article class="ticket-receipt">
        <p class="eyebrow">THECINEMA / BOOKING #<?= $booking["Booking_ID"] ?></p>
        <h2><?= e($booking["Title"]) ?></h2>
        <?php if ($tickets): $ticket = $tickets[0]; ?>
        <p><?= e($ticket["ShowDate"]) ?> · <?= substr($ticket["ShowTime"], 0, 5) ?> · <?= e($ticket["Hall"]) ?></p>
        <?php
        endif; ?>
        <hr />
        <?php foreach ($tickets as $ticket): ?>
        <p class="summary-row">
            <span>Row <?= e($ticket["Row"]) ?> / Seat <?= $ticket["SeatNumber"] ?></span>
            <span><?= e($ticket["Type"]) ?></span>
        </p>
        <?php endforeach; ?>
        <hr />
        <p class="summary-row">
            <strong><?= e($booking["PaymentStatus"]) ?></strong>
            <strong><?= money($booking["TotalAmount"]) ?></strong>
        </p>
        <p class="muted">Invoice #<?= $id ?> · <?= e($booking["InvoiceDate"]) ?></p>
    </article>
    <button class="button" id="print-booking" type="button">Print / save PDF</button>
    <a class="text-link" href="<?= url("movies") ?>">Back to films</a>
</main>
