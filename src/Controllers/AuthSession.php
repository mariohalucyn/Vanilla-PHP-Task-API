<?php

namespace App\Controllers;

use App\Http\Response;
use App\Initializers\Database;

require_once __DIR__ . '/../Initializers/Database.php';
require_once __DIR__ . '/../Http/Response.php';
require_once __DIR__ . '/../../config.php';

class AuthSession {
    public static function store(array $request): void {
        $db = Database::getInstance()->connection;

        $email = strtolower(trim($request['email']));
        $password = trim($request['password']);

        if (empty($email) || empty($password)) {
            Response::json([
                'success' => false,
                'message' => 'All fields are required'
            ], 422);
        }

        $db->begin_transaction();

        if (!$stmt = $db->prepare("SELECT id, first_name, last_name, email, password FROM `users` WHERE `email` = ?")) {
            Response::json([
                'success' => false,
                'message' => "Database error"
            ], 500);
        };

        $stmt->bind_param("s", $email) && $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            Response::json([
                'success' => false,
                'message' => 'User does not exist'
            ], 422);
        }

        if (!password_verify($password, $result->fetch_assoc()['password'])) {
            Response::json([
                'success' => false,
                'message' => 'Incorrect password'
            ], 422);
        }

        Response::json([
            'success' => true,
            'message' => 'User logged in successfully',
        ]);
    }

    public static function destroy(array $request): void {
    }
}