<?php

require './vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

use BitbullCustomers\Database\CustomerRepository;
use BitbullCustomers\Controller\CustomerController;
use BitbullCustomers\Database\MySqlConnection;


$controller = new CustomerController(
    new CustomerRepository(MySqlConnection::getInstance())
);

$controller->saveRandomFromCsv('./' . $_ENV['CSV_FILENAME']);
