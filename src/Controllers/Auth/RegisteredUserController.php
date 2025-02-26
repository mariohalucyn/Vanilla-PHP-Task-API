<?php

namespace App\Controllers\Auth;

use App\Controllers\Controller;
use App\Http\Response;
use App\Initializers\Database;
use JetBrains\PhpStorm\NoReturn;

class RegisteredUserController extends Controller {
    #[NoReturn] public static function store(array $request): void {
        $db = Database::getInstance()->connection;

        $first_name = trim($request['first_name']);
        $last_name = trim($request['last_name']);
        $email = strtolower(trim($request['email']));
        $password = trim($request['password']);

        if (empty($first_name) || empty($last_name) || empty($email) || empty($password)) {
            Response::json([
                'success' => false,
                'message' => 'All fields are required'
            ], 400);
        }

        $db->begin_transaction();

        if (!$stmt = $db->prepare("SELECT 1 FROM `users` WHERE `email` = ?")) {
            Response::json([
                'success' => false,
                'message' => 'Database error'
            ], 500);
        };
        $stmt->bind_param("s", $email) && $stmt->execute();
        if ($stmt->get_result()->num_rows > 0) {
            Response::json([
                'success' => false,
                'message' => 'This email is already registered'
            ], 422);
        }

        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $db->prepare("INSERT INTO `users` (`first_name`, `last_name` ,`email`, `password`) VALUES (?, ?, ?, ?)");
        if (!$stmt) {
            $db->rollback();
            Response::json([
                'success' => false,
                'message' => 'Database error'
            ], 500);
        }
        $stmt->bind_param("ssss", $first_name, $last_name, $email, $password_hash);
        $stmt->execute();
        if (!$stmt->affected_rows > 0) {
            Response::json([
                'success' => false,
                'message' => 'Failed to register'
            ], 500);
        }

        $stmt->close();
        $db->commit();

        Response::json([
            'success' => true,
            'message' => 'Registered successfully'
        ]);
    }
}