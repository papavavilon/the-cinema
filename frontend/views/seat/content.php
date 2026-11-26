<?php // Показуємо квитки та місця, які підготував контролер. ?>
<main id="main" class="wrap section">
    <?php heading(
        '01 / SEATS → 02 / DETAILS → 03 / CONFIRMATION',
        $screening['Title'],
        date('D j M', strtotime($screening['ShowDate'])) . ' · ' . substr($screening['ShowTime'], 0, 5) . ' · ' . $screening['Hall']
); ?>


    <form method="post" class="seat-form" id="seat-form">
        <?php csrf(); ?>
        <input type="hidden" name="screening_id" value="<?= $screening['Screening_ID'] ?>">

        <div class="booking-layout">
            <?php // Відвідувач обирає кількість квитків кожного типу. ?>

            <aside class="panel">
                <h2>Your tickets.</h2>
                <p class="muted">Choose up to 5 tickets, then select any available seats.</p>
                <?php foreach ($prices as $price): ?>
                    <label class="ticket-row">
                        <span>
                            <?= e($price['Type']) ?>
                            <small><?= money($price['Price'] + $screening['AdditionalFee']) ?></small>
                        </span>
                        <input
                            type="number"
                            min="0"
                            max="5"
                            value="<?= $price['Price_ID'] == 1 ? 1 : 0 ?>"
                            name="tickets[<?= $price['Price_ID'] ?>]"
                            data-price="<?= $price['Price'] + $screening['AdditionalFee'] ?>"
                            aria-label="<?= e($price['Type']) ?> ticket quantity"
                        >
                    </label>
                <?php endforeach; ?>
                <p class="muted">Format supplement included, where applicable.</p>
            </aside>

            <?php // Зайняті місця вимкнено, доступні можна позначити. ?>

            <section class="seat-panel">
                <div class="screen-arc">SCREEN</div>
                <p class="seat-hint muted">Swipe the seating plan to see all seats in each row.</p>
                <div class="seat-scroll">
                    <div class="seat-grid">
                        <?php foreach ($seatRows as $row => $rowSeats): ?>
                            <div class="seat-row">
                                <span class="row-label"><?= e($row) ?></span>
                                <?php foreach ($rowSeats as $seat): ?>
                                    <?php $booked = in_array($seat['Seat_ID'], $sold); ?>
                                    <label class="seat <?= $booked ? 'sold' : '' ?>">
                                        <input
                                            type="checkbox"
                                            name="seats[]"
                                            value="<?= $seat['Seat_ID'] ?>"
                                            <?= $booked ? 'disabled' : '' ?>
                                            aria-label="<?= e('Row ' . $row . ', seat ' . $seat['SeatNumber']) ?>"
                                        >
                                        <span><?= $seat['SeatNumber'] ?></span>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="legend">
                    <span>□ Available</span>
                    <span class="accent">■ Selected</span>
                    <span class="muted">▧ Booked</span>
                </div>
            </section>
        </div>

        <?php // Підсумок допомагає перевірити вибір перед наступним кроком. ?>
        <div class="booking-bar">
            <span id="selection-summary" aria-live="polite">Select your seats</span>
            <strong id="selection-total"></strong>
            <button class="button" id="seat-continue" type="submit">Continue ↗</button>
        </div>
        <p class="muted">Seats are reserved only when you confirm your booking.</p>
    </form>
</main>
