<?php

declare(strict_types=1);

namespace BitbullCustomers\Database;

use BitbullCustomers\Database\MySqlConnection;
use BitbullCustomers\Model\Customer;
use mysqli;
use Exception;

class CustomerRepository
{
    private mysqli $connection;

    public function __construct(MySqlConnection $connection)
    {
        $this->connection = $connection->getConnection();
    }

    public function save(Customer $customer): void
    {
        $this->connection->begin_transaction();

        try {
            $this->saveCustomerData($customer);
            $this->saveCustomerAddress($customer);

            if (count($customer->phoneNumbers()) > 0) {
                $this->saveCustomerPhoneNumbers($customer);
            }

            $this->connection->commit();
        } catch (Exception $e) {
            $this->connection->rollback();
            throw new Exception($e->getMessage());
        }

        $this->connection->close();
    }

    private function saveCustomerData(Customer $customer): void
    {
        $stmt = $this->connection->prepare("INSERT INTO customer_data (id, country, name, reg_no, vat_no) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", ...$customer->values());
        $stmt->execute();
        $stmt->close();
    }

    private function saveCustomerAddress(Customer $customer): void
    {
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
    }

    private function saveCustomerPhoneNumbers(Customer $customer): void
    {
        $customerId = $customer->id();
        foreach ($customer->phoneNumbers() as $phoneNumber) {
            $stmt = $this->connection->prepare("INSERT INTO customer_phone_number (value, customer_id) VALUES (?, ?)");
            $stmt->bind_param("ss", $phoneNumber, $customerId);
            $stmt->execute();
            $stmt->close();
        }
    }
}
