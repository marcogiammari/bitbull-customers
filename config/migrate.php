<?php

$config = require './config/database.php';

try {
    $conn = new mysqli(
        $config['host'],
        $config['user'],
        $config['password'],
        $config['database']
    );
} catch (Exception $e) {
    echo "An error occurred: " . $e->getMessage();
}

$sqlCustomersData = "
CREATE TABLE `customer_data` (
    `id` varchar(30) NOT NULL,
    `country` varchar(10) NOT NULL,
    `reg_no` varchar(30) NOT NULL,
    `vat_no` varchar(30) NOT NULL,
    `name` varchar(255) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
";

$sqlCustomersAddress = "
CREATE TABLE `customer_address` (
    `id` int(11) NOT NULL,
    `value` varchar(255) NOT NULL,
    `street` varchar(255) NOT NULL,
    `city` varchar(100) NOT NULL,
    `post_code` varchar(20) NOT NULL,
    `province` varchar(20) NOT NULL,
    `house_no` varchar(20) NOT NULL,
    `customer_id` varchar(30) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
";

$sqlCustomersPhoneNumbers = "
CREATE TABLE `customer_phone_number` (
    `id` int(11) NOT NULL,
    `value` varchar(30) NOT NULL,
    `customer_id` varchar(30) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
";


$conn->query($sqlCustomersData);
$conn->query($sqlCustomersAddress);
$conn->query($sqlCustomersPhoneNumbers);
$conn->query("ALTER TABLE `customer_address` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;");
$conn->query("ALTER TABLE `customer_phone_number` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;");


$conn->close();
