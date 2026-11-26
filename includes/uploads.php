<?php

// Перевіряємо тип і розмір зображення перед збереженням.
function upload_image($field, $folder)
{
    if (empty($_FILES[$field]["name"])) {
        return null;
    }
    $f = $_FILES[$field];
    if ($f["error"] !== UPLOAD_ERR_OK || $f["size"] > 8 * 1024 * 1024) {
        throw new RuntimeException("Upload a JPG, PNG or WebP image smaller than 8 MB.");
    }
    $mime = (new finfo(FILEINFO_MIME_TYPE))->file($f["tmp_name"]);
    $ext = ["image/jpeg" => "jpg", "image/png" => "png", "image/webp" => "webp"][$mime] ?? null;
    if (!$ext || !getimagesize($f["tmp_name"])) {
        throw new RuntimeException("Please choose a valid image.");
    }
    $name = bin2hex(random_bytes(12)) . "." . $ext;
    if (!move_uploaded_file($f["tmp_name"], ROOT_PATH . "/uploads/" . $folder . "/" . $name)) {
        throw new RuntimeException("Cannot save image. Give XAMPP write access to the uploads folder.");
    }
    return $name;
}
