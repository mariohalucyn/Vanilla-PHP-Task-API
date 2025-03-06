<?php

namespace App\Initializers;

use mysqli;

class Database {
    private static ?Database $instance = null;
    public mysqli $connection {
        get {
            return $this->connection;
        }
    }

    public function __construct() {
        $this->initialize();
    }

    private function initialize(): void {
        $host = $_ENV['DB_HOST'];
        $user = $_ENV['DB_USER'];
        $password = $_ENV['DB_PASSWORD'];
        $name = $_ENV['DB_NAME'];
        $port = $_ENV['DB_PORT'];
        $this->connection = new mysqli($host, $user, $password, $name, $port);
    }

    public static function getInstance(): ?Database {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}