<?php

require './vendor/autoload.php';
require './src/database/MySqlConnection.php';
require './src/database/CustomerRepository.php';
require './src/controller/CustomerController.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

use Database\CustomerRepository;
use Database\MySqlConnection;
use Controller\CustomerController;


$controller = new CustomerController(
    new CustomerRepository(MySqlConnection::getInstance())
);

var_dump($controller->saveRandomFromCsv('./' . $_ENV['CSV_FILENAME']));
