<?php

// Перевіряємо права працівника та обробляємо зміни в адмінпанелі.
class AdminController
{
    private PDO $db;
    // Отримуємо підключення до бази для цього контролера.
    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    // Перевіряємо запит, готуємо дані та обираємо наступну сторінку.
    public function handle(string $path): void
    {
        $db = $this->db;
        $model = new AdminModel($db);
        // Перший обліковий запис працівника створює власник на своєму комп’ютері.
        if ($path === "setup") {
            if (!local_request() || $model->countAdmin([])->fetchColumn()) {
                http_response_code(403);
                throw new RuntimeException(
                    "Setup is available only on localhost before the first administrator is created."
                );
            }
            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                $email = trim($_POST["email"] ?? "");
                $pass = $_POST["password"] ?? "";
                if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !password_ok($pass)) {
                    throw new RuntimeException(
                        "Enter a valid email and a password of at least 10 characters."
                    );
                }
                $model->insertAdmin([$email, password_hash($pass, PASSWORD_DEFAULT)]);
                $_SESSION["admin_id"] = $db->lastInsertId();
                session_regenerate_id(true);
                flash("Your staff account is ready.");
                go("admin/dashboard");
            }

            // Передаємо підготовлені дані до шаблону сторінки.
            page_head("Set up your cinema", true);
            require ROOT_PATH . "/admin/views/setup.php";
            page_foot();
            return;
        }
        if ($path === "admin/login") {
            $adminCount = $model->countAdmin([])->fetchColumn();

            // Передаємо підготовлені дані до шаблону сторінки.
            page_head("Staff sign in", true);
            require ROOT_PATH . "/admin/views/login.php";
            page_foot();
            return;
        }
        if (empty($_SESSION["admin_id"])) {
            go("admin/login");
        }
        // Назви таблиць і полів беремо тільки з цього дозволеного списку.
        $sections = require ROOT_PATH . "/config/admin_sections.php";
        $key = str_replace("admin/manage-", "", $path);
        $sec = $sections[$key] ?? null;
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            if ($sec) {
                $id = (int) ($_POST["id"] ?? 0);
                $table = $sec["table"];
                $pk = $sec["pk"];
                if (isset($_POST["delete"])) {
                    if ($key === "company") {
                        throw new RuntimeException("Cinema details cannot be deleted.");
                    }
                    try {
                        $model->deleteRecords([$id], $table, $pk);
                    } catch (PDOException $e) {
                        throw new RuntimeException(
                            "This item is linked to bookings or other records. Keep it to preserve booking history."
                        );
                    }
                } else {
                    $values = [];
                    $cols = array_keys($sec["fields"]);
                    foreach ($sec["fields"] as $col => $type) {
                        $value = trim($_POST[$col] ?? "");
                        if ($value === "" && $col !== "TrailerLink") {
                            throw new RuntimeException("Complete all required fields.");
                        }
                        if ($type === "email" && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                            throw new RuntimeException("Enter a valid email.");
                        }
                        if ($type === "number" && (!is_numeric($value) || (float) $value < 0)) {
                            throw new RuntimeException("Use a positive number.");
                        }
                        if (
                            $type === "date" &&
                            (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $value) ||
                                date("Y-m-d", strtotime($value)) !== $value)
                        ) {
                            throw new RuntimeException("Use a valid date.");
                        }
                        if ($type === "time" && !preg_match('/^\d{2}:[0-5]\d(:[0-5]\d)?$/', $value)) {
                            throw new RuntimeException("Use a time in HH:MM format.");
                        }
                        if (
                            $col === "TrailerLink" &&
                            $value &&
                            !preg_match('~^https://www.youtube.com/embed/[A-Za-z0-9_-]+$~', $value)
                        ) {
                            throw new RuntimeException(
                                "Use a YouTube embed URL, or leave the trailer empty."
                            );
                        }
                        $values[] = $value;
                    }
                    if ($key === "movies" && (int) ($_POST["Year"] ?? 0) < 1888) {
                        throw new RuntimeException("Enter a valid release year.");
                    }
                    if ($key === "movies" && minutes($_POST["Duration"]) < 1) {
                        throw new RuntimeException("A film duration must be greater than zero.");
                    }
                    // Перевіряємо, чи нова тривалість фільму не накладає один сеанс на інший.
                    if ($key === "movies" && $id) {
                        $conflict = $model
                            ->countOverlappingScreenings([$id, $id, $_POST["Duration"], $_POST["Duration"]])
                            ->fetchColumn();
                        if ($conflict) {
                            throw new RuntimeException(
                                "This duration would overlap an existing screening. Adjust the screening times first."
                            );
                        }
                    }
                    if ($key === "screenings" && (int) substr($_POST["ShowTime"], 0, 2) > 23) {
                        throw new RuntimeException("Choose a screening time between 00:00 and 23:59.");
                    }
                    if ($key === "screenings" && $id && $model->countTicket([$id])->fetchColumn()) {
                        $old = $model->fetchScreening([$id])->fetch();
                        foreach ($cols as $c) {
                            if (
                                (string) $old[$c] !== (string) ($_POST[$c] ?? "") &&
                                !($c === "ShowTime" && substr($old[$c], 0, 5) === ($_POST[$c] ?? ""))
                            ) {
                                throw new RuntimeException(
                                    "This screening already has bookings. Cancel them before changing its film, hall or time."
                                );
                            }
                        }
                    }
                    $db->beginTransaction();
                    if ($id) {
                        $model->updateRecords(array_merge($values, [$id]), $table, $cols, $pk);
                    } else {
                        $model->insertRecords($values, $table, $cols);
                        $id = $db->lastInsertId();
                    }
                    if ($key === "movies") {
                        foreach (["poster" => 1, "gallery" => 0] as $field => $featured) {
                            $name = upload_image($field, $field);
                            if ($name) {
                                $model->deleteMedia([$id, $featured]);
                                $model->insertMedia([
                                    $name,
                                    $featured,
                                    pathinfo($name, PATHINFO_EXTENSION),
                                    $id
                                ]);
                            }
                        }
                    }
                    $db->commit();
                }
                flash("Saved.");
                go("admin/manage-" . $key);
            }
            if ($path === "admin/manage-messages") {
                $m = $model->fetchContactMessages([(int) ($_POST["id"] ?? 0)])->fetch();
                $reply = trim($_POST["reply"] ?? "");
                if (!$m || !$reply) {
                    throw new RuntimeException("Write a reply first.");
                }
                $model->updateContactMessages([$reply, $m["Message_ID"]]);
                outbox($m["Email"], "thecinema · " . $m["Subject"], $reply);
                flash("Reply saved to the local demo mailbox.");
                go("admin/manage-messages");
            }
            if ($path === "admin/manage-bookings") {
                $id = (int) ($_POST["id"] ?? 0);
                $db->beginTransaction();
                $b = $model->lockBooking([$id])->fetch();
                if (!$b) {
                    throw new RuntimeException("Booking not found.");
                }
                $model->deleteTicket([$id]);
                $model->cancelBooking([$id]);
                $model->cancelInvoice([$b["Invoice_ID"]]);
                $db->commit();
                flash("Booking cancelled and seats released.");
                go("admin/manage-bookings");
            }
            if ($path === "admin/dashboard" && isset($_POST["refresh_schedule"])) {
                // Додаємо майбутні сеанси з перервою між показами.
                (new ScheduleService($db))->generate(42);
                flash("Schedule extended for the next 42 days.");
                go("admin/dashboard");
            }
        }

        $id = (int) ($_GET["edit"] ?? 0);
        $editing = [];
        $rows = [];
        $options = [];
        $showform = $id || isset($_GET["new"]);
        if ($sec) {
            $editing = $id ? $model->findRecord([$id], $sec)->fetch() : [];
            if ($id && !$editing) {
                throw new RuntimeException("This record no longer exists.");
            }
            $rows = $model->listRecords([], $sec)->fetchAll();
            foreach (
                ["movie" => "Movie", "hall" => "CinemaHall", "genre" => "Genre", "version" => "Version"]
                as $type => $table
            ) {
                $options[$type] = $model->listOptions([], $table)->fetchAll();
            }
        }
        $messages = [];
        $letters = [];
        $bookings = [];
        $stats = [];
        if ($path === "admin/manage-messages") {
            $messages = $model->listMessages([])->fetchAll();
        }
        if ($path === "admin/outbox") {
            $letters = $model->fetchMailOutbox([])->fetchAll();
        }
        if ($path === "admin/manage-bookings") {
            $bookings = $model->fetchBooking([])->fetchAll();
        }
        if ($path === "admin/dashboard") {
            foreach (["Movie", "Screening", "Booking"] as $t) {
                $stats[$t] = $model->countRecords([], $t)->fetchColumn();
            }
        }

        // Передаємо підготовлені дані до шаблону сторінки.
        page_head($sec["title"] ?? "Staff dashboard", true);
        require ROOT_PATH . "/admin/views/dashboard.php";
        page_foot();
    }
}
