<?php

// Допоміжна перевірка збереження листа.
function outbox($email, $subject, $body)
{
    global $db;
    $model = new MailModel($db);
    $model->insertMailOutbox([$email, $subject, $body]);
    if (!$db->inTransaction()) {
        try {
            (new MailService())->send($email, $subject, $body);
        } catch (Throwable $error) {
            error_log("Email delivery failed: " . $error->getMessage());
        }
    }
}
