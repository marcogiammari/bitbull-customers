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
            $stmt = $this->connection->prepare("INSERT INTO customer (id, country, name, reg_no, vat_no) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", ...$customer->values());
            $stmt->execute();
            $stmt->close();

            $customerId = $customer->id();
            $addressValues = $customer->addressValues();
            $addressValues[] = $customerId;

            $stmt = $this->connection->prepare("INSERT INTO customer_address (value, street, city, post_code, province, house_no, customer_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param(
                "sssssss",
                ...$addressValues
            );
            $stmt->execute();
            $stmt->close();

            $stmt = $this->connection->prepare("INSERT INTO customer_phone_number (value, customer_id) VALUES (?, ?)");

            if (count($customer->phoneNumbers()) > 0) {
                foreach ($customer->phoneNumbers() as $phoneNumber) {

                    $stmt->bind_param("ss", $phoneNumber, $customerId);
                    $stmt->execute();
                }
            }
            $stmt->close();

            $this->connection->commit();
        } catch (Exception $e) {
            $this->connection->rollback();
            throw new Exception($e->getMessage());
        }

        $this->connection->close();
    }
}
