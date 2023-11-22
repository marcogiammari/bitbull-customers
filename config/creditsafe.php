<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

return [
    'auth_url' => $_ENV['CS_AUTH_URL'],
    'companies_url' => $_ENV['CS_COMPANIES_URL'],
    'auth_data' => [
        'username' => $_ENV['CS_USERNAME'],
        'password' => $_ENV['CS_PASSWORD'],
    ]
];
