<?php

namespace App\Controllers\User;

use App\Controllers\Controller;
use App\Http\Response;
use App\Initializers\Database;

class User extends Controller {
    public static function index(): void {
        $db = Database::getInstance()->connection;

        if (!isset($_SESSION['id'])) {
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized']);
            exit();
        }

        $id = $_SESSION['id'];
        if (!$stmt = $db->prepare("SELECT * FROM users WHERE id = ?")) {
            Response::json([
                'success' => false,
                'message' => 'Database error'
            ], 500);
        }
        $stmt->bind_param("i", $id) && $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($result->num_rows === 0) {
            Response::json([
                'success' => false,
                'message' => 'User not found'
            ], 400);
        }

        Response::json([
            'success' => true,
            'message' => 'User found',
            'data' => $user
        ]);
    }
}