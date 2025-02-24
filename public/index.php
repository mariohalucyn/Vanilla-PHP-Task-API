<?php

require_once __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . "/../src/Initializers/Database.php";
require_once __DIR__ . "/../src/Http/Response.php";
require_once __DIR__ . "/../src/Controllers/AuthSession.php";
require_once __DIR__ . "/../src/Controllers/Register.php";
require_once __DIR__ . "/../config.php";

use App\Controllers\Register;
use App\Http\Response;
use App\Initializers\Database;
use App\Controllers\AuthSession;

$db = new Database();
$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

switch ($requestUri) {
    case '/api/auth/login':
        if ($requestMethod == 'POST') {
            AuthSession::store(json_decode(file_get_contents("php://input"), true));
        } else {
            Response::json([
                'success' => false,
                'message' => 'Method not allowed'
            ], 405);
        }
        break;

    case '/api/auth/logout':
        if ($requestMethod == 'GET') {
            AuthSession::destroy(json_decode(file_get_contents("php://input"), true));
        } else {
            Response::json([
                'success' => false,
                'message' => 'Method not allowed'
            ], 405);
        }
        break;

    case '/api/auth/register':
        if ($requestMethod == 'POST') {
            Register::store(json_decode(file_get_contents("php://input"), true));
        } else {
            Response::json([
                'success' => false,
                'message' => 'Method not allowed'
            ], 405);
        }
        break;

    case '/api/user':
        if ($requestMethod == 'GET') {
            session_abort();
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
            ], 200);

        }
        break;


    default:
        Response::json(['success' => false, 'message' => 'Not found'], 404);
}