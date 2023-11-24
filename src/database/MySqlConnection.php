<?php

declare(strict_types=1);

namespace BitbullCustomers\Database;

use mysqli;
use Exception;

class MySqlConnection

{
    private static $instance;
    private $connection;

    private function __construct()
    {
        $config = include './config/database.php';

        try {
            $this->connection = new mysqli(
                $config['host'],
                $config['user'],
                $config['password'],
                $config['database'],
            );
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public static function getInstance(): MySqlConnection
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getConnection(): mysqli
    {
        return $this->connection;
    }
}
