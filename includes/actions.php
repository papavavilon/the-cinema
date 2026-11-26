<?php

// За адресою форми обираємо обробник POST-запиту.
return [
    "admin/create-invoice" => "StaffInvoiceAction",
    "user/login" => "LoginAction",
    "admin/login" => "LoginAction",
    "user/new_user" => "RegisterAction",
    "user/logout" => "LogoutAction",
    "admin/logout" => "StaffLogoutAction",
    "user/forgot-password" => "ForgotPasswordAction",
    "user/reset-password" => "ResetPasswordAction",
    "user/profiles" => "UpdateProfileAction",
    "contact" => "SendMessageAction",
    "seat" => "SelectSeatsAction",
    "checkout" => "CheckoutAction"
];
