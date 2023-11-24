<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

return [
    'auth_url' => 'https://connect.creditsafe.com/v1/authenticate',
    'companies_url' => 'https://connect.creditsafe.com/v1/companies',
    'auth_data' => [
        'username' => $_ENV['CS_USERNAME'],
        'password' => $_ENV['CS_PASSWORD'],
    ]
];
