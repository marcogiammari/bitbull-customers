<?php

declare(strict_types=1);

namespace Database;

use Database\MySql;

class CustomerRepository
{
    static function save($customer): void
    {
        $sql = "INSERT INTO customer_data (id, country, name, regNo) VALUES (?, ?, ?, ?)";
        $connection = MySqlConnection::getInstance()->getConnection();
        $stmt = $connection->prepare($sql);
        $values = $customer->values();
        $stmt->bind_param('ssss', ...$values);
        $stmt->execute();
    }
}
