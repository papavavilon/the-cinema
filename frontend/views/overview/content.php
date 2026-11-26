<?php
/* Показуємо деталі замовлення. */ ?>
<main id="main" class="wrap section">
    <?php heading("01 / SEATS → 02 / DETAILS → 03 / CONFIRMATION", "Almost showtime."); ?>
    <div class="checkout-layout">

        <section class="panel">
            <h2><?= e($screening["Title"]) ?></h2>
            <p><?= e(date("D, j M Y", strtotime($screening["ShowDate"]))) ?>
                · <?= substr($screening["ShowTime"], 0, 5) ?> · <?= e($screening["Hall"]) ?></p>
            <p>
                Seats:
                <?php foreach ($order["seats"] as $seat) {
                    echo '<span class="chip">Row ' . e($seat["Row"]) . " / " . e($seat["SeatNumber"]) . "</span> ";
                } ?>
            </p>
            <hr />
            <?php foreach ($order["tickets"] as $ticket): ?>
            <p class="summary-row">
                <span><?= $ticket["quantity"] ?> × <?= e($ticket["price"]["Type"]) ?></span>
                <span><?= money($ticket["quantity"] * ($ticket["price"]["Price"] + $screening["AdditionalFee"])) ?></span>
            </p>
            <?php endforeach; ?>
            <p class="summary-row total">
                <span>Total before offers</span>
                <strong><?= money($order["total"]) ?></strong>
            </p>
            <a class="text-link" href="<?= url("seat?screening_id=" . $screening["Screening_ID"]) ?>">Change seats</a>
        </section>

        <form class="panel" method="post" action="<?= url("checkout") ?>">
            <?php csrf(); ?>
            <input type="hidden" name="nonce" value="<?= e($_SESSION["booking_nonce"]) ?>" />
            <h2>Your details.</h2>
            <?php if ( empty($_SESSION["user_id"])): ?>
            <p>
                Continue as a guest or
                <a class="text-link" href="<?= url("user/login") ?>">sign in</a>
                .
            </p>
            <div class="form-row">
                <label>
                    First name
                    <input name="firstname" required maxlength="100" autocomplete="given-name" />
                </label>
                <label>
                    Last name
                    <input name="lastname" required maxlength="100" autocomplete="family-name" />
                </label>
            </div>
            <label>
                Email
                <input name="email" type="email" required autocomplete="email" />
            </label>
            <label>
                Phone
                <small>(optional)</small>
                <input name="phone" type="tel" maxlength="25" autocomplete="tel" />
            </label>
            <?php else:$user = $account; ?>
            <p>
                <?= e($user["Name"]) ?>
                <br />
                <?= e($user["Email"]) ?>
            </p>
            <?php endif; ?>
            <label>
                Offer code
                <small>(optional)</small>
                <input name="coupon" placeholder="e.g. CINEMA20" maxlength="50" />
            </label>
            <p class="notice">
                Demo booking. No payment is taken. Confirmation is stored in your account or this browser
                session.
            </p>
            <button class="button" type="submit">Confirm demo booking ↗</button>
        </form>
    </div>
</main>
