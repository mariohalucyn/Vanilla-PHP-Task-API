<?php

namespace App\Initializers;

use mysqli;

class Database {
    public mysqli $connection {
        get {
            return $this->connection;
        }
    }
    private static ?Database $instance = null;

    public static function getInstance(): ?Database {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function __construct() {
        $this->initialize();
    }

    private function initialize(): void {
        $host = $_ENV['DB_HOST'];
        $user = $_ENV['DB_USER'];
        $password = $_ENV['DB_PASSWORD'];
        $name = $_ENV['DB_NAME'];
        $this->connection = new mysqli($host, $user, $password, $name);
    }
}