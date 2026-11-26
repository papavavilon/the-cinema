<?php

// Допоміжна перевірка фільму.
function movie($id)
{
    global $db;
    $model = new MovieModel($db);
    return $model->findMovie([(int) $id])->fetch();
}
