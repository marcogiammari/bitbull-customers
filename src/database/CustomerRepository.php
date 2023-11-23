<?php

declare(strict_types=1);

namespace Database;

use Database\MySqlConnection;
use mysqli;
use Exception;

class CustomerRepository
{
    private mysqli $connection;

    public function __construct(MySqlConnection $connection)
    {
        $this->connection = $connection->getConnection();
    }

    public function save($customer): void
    {
        $this->connection->begin_transaction();

        try {
            $stmt = $this->connection->prepare("INSERT INTO customer (id, country, name, regNo, vatNo) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", ...$customer->values());
            $stmt->execute();
            $stmt->close();

            $this->connection->commit();
        } catch (Exception $e) {
            $this->connection->rollback();
            throw new Exception($e->getMessage());
        }

        $this->connection->close();
    }
}
