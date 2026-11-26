<?php

// Допоміжна перевірка сеансу.
function screening($id, $lock = false)
{
    global $db;
    $model = new BookingModel($db);
    return $model->findScreening([(int) $id], $lock)->fetch();
}
