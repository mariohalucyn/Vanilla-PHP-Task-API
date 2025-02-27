<?php

require_once __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . "/../src/Initializers/Database.php";
require_once __DIR__ . "/../src/Http/Response.php";
require_once __DIR__ . "/../src/Controllers/AuthSession.php";
require_once __DIR__ . "/../src/Controllers/Register.php";
require_once __DIR__ . "/../src/Controllers/User.php";
require_once __DIR__ . "/../config.php";

use App\Controllers\AuthSession;
use App\Controllers\Register;
use App\Controllers\User;
use App\Http\Response;
use App\Initializers\Database;

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
        if ($requestMethod == 'POST') {
            AuthSession::destroy();
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
            User::index();
        } else {
            Response::json([
                'success' => false,
                'message' => 'Method not allowed'
            ]);
        }
        break;


    default:
        Response::json(['success' => false, 'message' => 'Not found'], 404);
}