<?php

// Допоміжна перевірка промокоду.
function coupon($code, $total)
{
    global $db;
    $model = new BookingModel($db);
    if (!$code) {
        return [null, 0];
    }
    $c = $model->fetchCoupon([$code])->fetch();
    if (!$c) {
        throw new RuntimeException("This offer code is invalid or has expired.");
    }
    return [$c["Coupon_ID"], min($total, max(0, (float) $c["DiscountAmount"]))];
}
