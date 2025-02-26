<?php

namespace App\Models;

use App\Initializers\Database;
use Exception;
use mysqli;

class User {
    private mysqli $db;

    public function __construct() {
        $this->db = Database::getInstance()->connection;
    }

    /**
     * @throws Exception
     */
    public function findById(int $id): array {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        if (!$stmt) {
            throw new Exception('Database error', 500);
        }

        $stmt->bind_param("i", $id);
        if (!$stmt->execute()) {
            throw new Exception('Database error', 500);
        }

        $result = $stmt->get_result();
        if ($result->num_rows === 0) {
            throw new Exception('User not found', 404);
        }

        $stmt->close();

        return $result->fetch_assoc();
    }

    /**
     * @throws Exception
     */
    public function findByEmail(string $email): ?array {
        $stmt = $this->db->prepare("SELECT id, first_name, last_name, email, password FROM users WHERE email = ?");
        if (!$stmt) {
            throw new Exception('Database error', 500);
        }

        $stmt->bind_param("s", $email);
        if (!$stmt->execute()) {
            throw new Exception('Database error', 500);
        }

        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        return $user ?: null;
    }

    /**
     * @throws Exception
     */
    public function update(int $id, string $firstName, string $lastName): void {
        $stmt = $this->db->prepare("UPDATE users SET first_name = ?, last_name = ? WHERE id = ?");
        if (!$stmt) {
            throw new Exception('Database error', 500);
        }

        $stmt->bind_param("ssi", $firstName, $lastName, $id);
        if (!$stmt->execute()) {
            throw new Exception('Database error', 500);
        }

        if (!$stmt->execute()) {
            throw new Exception('Database error (execute failed)', 500);
        }
    }
}
