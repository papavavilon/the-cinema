<?php

// Створюємо одне підключення PDO до бази The Cinema.
class Database
{
    private PDO $connection;
    public function __construct(array $config)
    {
        $dsn =
            "mysql:host=" .
            $config["db_host"] .
            ";port=" .
            $config["db_port"] .
            ";dbname=" .
            $config["db_name"] .
            ";charset=utf8mb4";
        $this->connection = new PDO($dsn, $config["db_user"], $config["db_pass"], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]);
        $this->connection->exec("SET time_zone = '" . date("P") . "'");
    }
    public function connection(): PDO
    {
        return $this->connection;
    }
}
