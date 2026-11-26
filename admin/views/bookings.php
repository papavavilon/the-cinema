<?php // Бронювання, створення рахунків та скасування квитків. ?>
<div class="table-scroll">
    <table>
        <thead>
            <tr>
                <th>Booking</th>
                <th>Film</th>
                <th>Tickets</th>
                <th>Total</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ( $bookings as $b): ?>
            <tr>
                <td><a href="<?= url("invoice?invoice_id=" . $b["Invoice_ID"]) ?>">#<?= $b["Booking_ID"] ?></a></td>
                <td><?= e($b["Title"]) ?></td>
                <td><?= $b["NumberOfTickets"] ?></td>
                <td><?= money($b["TotalPrice"]) ?></td>
                <td><?= e($b["PaymentStatus"]) ?></td>
                <td>

                    <form method="post" action="<?= url('admin/create-invoice') ?>">
                        <?php csrf(); ?>
                        <input type="hidden" name="id" value="<?= $b['Booking_ID'] ?>">
                        <button class="text-button">Create / view invoice</button>
                    </form>
                    <?php if ( $b["PaymentStatus"] !== "Cancelled"): ?>

                    <form method="post" data-confirm="Cancel this booking and release its seats?">
                        <?php csrf(); ?>
                        <input type="hidden" name="id" value="<?= $b["Booking_ID"] ?>" />
                        <button class="text-button danger">Cancel</button>
                    </form>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
