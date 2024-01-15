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
            $this->connection = new PDO(
                $dsn,
                $username,
                $password,
                //optional atributes, fetch will return associative array
                [
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );
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

    public function find() :mixed
    {
        return $this->statement->fetch();
    }

/**
* Retrieve the last inserted ID from the database connection.
*
* This method returns the last auto-generated ID that was inserted into the database.
* It is typically used after an INSERT operation to obtain the unique identifier
* assigned to the newly created record.
*
* @return string|false The last inserted ID as a string or false if no ID is available.
*/
    public function id() : string|false
    {
        return $this->connection->lastInsertId();
    }
}