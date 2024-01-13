<?php
declare(strict_types=1);

namespace Framework;

use PDO, \PDOException;

class Database
{
    private PDO $connection;
    private \PDOStatement $statement;
    public function __construct(
        string $driver,
        array  $config,
        string $username,
        string $password
    )
    {
        $config = http_build_query(data: $config, arg_separator: ';');

        $dsn = "{$driver}:{$config}";

        try {
            $this->connection = new PDO($dsn, $username, $password);
        }catch (PDOException $e) {
            die('Cannot connect to database');
        }
        echo "Connected to database";
    }

    public function query(string $query, array $parameters = []): self {

        $this->statement = $this->connection->prepare($query);
        $this->statement->execute($parameters);

        return $this;
    }

    public function count(): int|null
    {
        return $this->statement->fetchColumn();
    }
}