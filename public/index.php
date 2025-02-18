<?php

require_once __DIR__."/../vendor/autoload.php";
require_once __DIR__."/../src/Initializers/Database.php";
require_once __DIR__."/../src/Http/Response.php";
require_once __DIR__ . "/../src/Controllers/AuthSession.php";
require_once __DIR__."/../config.php";

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
            Response::json(['success' => false, 'message' => 'Method not allowed'], 405);
        }
        break;

    case '/api/auth/logout':
        if ($requestMethod == 'GET') {
            AuthSession::destroy(json_decode(file_get_contents("php://input"), true));
        } else {
            Response::json(['success' => false, 'message' => 'Method not allowed'], 405);
        }
        break;

    case '/api/auth/register':
        if ($requestMethod == 'POST') {
            Register::store(json_decode(file_get_contents("php://input"), true));
        } else {
            Response::json(['success' => false, 'message' => 'Method not allowed'], 405);
        }
        break;

    default:
        Response::json(['success' => false, 'message' => 'Not found'], 404);
}