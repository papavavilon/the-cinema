<?php // Кількість записів та продовження розкладу. ?>
<div class="info-grid">
    <?php foreach ( ["Movie" => "Films", "Screening" => "Screenings", "Booking" => "Bookings"] as $t => $label): ?>
    <div class="panel stat">
        <p class="eyebrow"><?= $label ?></p>
        <strong><?= $stats[$t] ?></strong>
    </div>
    <?php endforeach; ?>
</div>
<div class="panel">
    <h2>Keep the screen alive.</h2>
    <p>
        Add a fresh 42-day demo schedule. Existing screenings and bookings stay in place. Each film has a
        15-minute turnaround buffer.
    </p>

    <form method="post">
        <?php csrf(); ?>
        <button class="button" name="refresh_schedule">Extend schedule ↗</button>
    </form>
</div>
<div class="panel">
    <h2>Everything in one place.</h2>
    <p>
        Edit cinema details, films, screenings, the home-page spotlight, offers and journal articles using
        the tabs above.
    </p>
    <p class="muted">Student demo. Payments are simulated. Email delivery requires the cinema mail settings.</p>
</div>
