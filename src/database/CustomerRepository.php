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
            $stmt1 = $this->connection->prepare("INSERT INTO customer (id, country, name, regNo) VALUES (?, ?, ?, ?)");
            $stmt1->bind_param("ssss", ...$customer->values());
            $stmt1->execute();
            $stmt1->close();

            // TODO: implement vatNo
            // $stmt2 = $this->connection->prepare("INSERT INTO customer_vatNo (vatNo, customer_id) VALUES (?, ?)");
            // $stmt2->bind_param("ss", $vatNo, $customer-> ID !!!!);
            // $stmt2->execute();
            // $stmt2->close();

            $this->connection->commit();
        } catch (Exception $e) {
            $this->connection->rollback();
            throw new Exception($e->getMessage());
        }

        $this->connection->close();
    }
}
