<?php
/* Показуємо профіль і замовлення. */ ?>
<main id="main" class="wrap section">
    <?php heading("THECINEMA / YOUR ACCOUNT", "Good to see you, " . $user["Name"] . "."); ?>
    <div class="checkout-layout">

        <section>
            <h2>Your bookings.</h2>
            <?php
            if (!$bookings) {
                echo '<p class="muted">Your next cinema night starts with a film.</p>';
            }
            foreach ($bookings as $booking): ?>
            <a class="booking-item" href="<?= url("invoice?invoice_id=" . $booking["Invoice_ID"]) ?>">
                <div>
                    <h3><?= e($booking["Title"]) ?></h3>
                    <p>#<?= $booking["Booking_ID"] ?> · <?= $booking["NumberOfTickets"] ?> tickets · <?= e($booking["PaymentStatus"]) ?></p>
                </div>
                <span><?= money($booking["TotalPrice"]) ?> ↗</span>
            </a>
            <?php endforeach; ?>
            <a class="button" href="<?= url("movies") ?>">Find a film ↗</a>
        </section>

        <aside>

            <form class="panel" method="post">
                <?php csrf(); ?>
                <h2>Your details.</h2>
                <label>
                    Email
                    <input type="email" name="email" required value="<?= e($user["Email"]) ?>" />
                </label>
                <label>
                    Phone
                    <input type="tel" name="phone" maxlength="25" value="<?= e($user["TelephoneNumber"]) ?>" />
                </label>
                <button class="button outline">Save details</button>
            </form>

            <form method="post" action="<?= url("user/logout") ?>">
                <?php csrf(); ?>
                <button class="text-button">Sign out</button>
            </form>
        </aside>
    </div>
</main>
