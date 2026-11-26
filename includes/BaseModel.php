<?php

// Спільне підключення моделей до бази. Значення передаються окремо від SQL.
class BaseModel
{
    protected PDO $db;
    public function __construct(PDO $connection)
    {
        $this->db = $connection;
    }
    protected function query(string $sql, array $parameters = []): PDOStatement
    {
        $statement = $this->db->prepare($sql);
        $statement->execute($parameters);
        return $statement;
    }
}
