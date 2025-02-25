<?php

require_once __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . "/../src/Http/Response.php";
require_once __DIR__ . "/../src/Controllers/Controller.php";
require_once __DIR__ . "/../config.php";

use App\Controllers\Auth\AuthenticatedSessionController;
use App\Controllers\Auth\RegisteredUserController;
use App\Controllers\User\UserController;
use App\Http\Response;

$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

switch ($requestUri) {
    case '/api/auth/login':
        if ($requestMethod == 'POST') {
            AuthenticatedSessionController::store(json_decode(file_get_contents("php://input"), true));
        } else {
            Response::json([
                'success' => false,
                'message' => 'Method not allowed'
            ], 405);
        }
        break;

    case '/api/auth/logout':
        if ($requestMethod == 'POST') {
            AuthenticatedSessionController::destroy();
        } else {
            Response::json([
                'success' => false,
                'message' => 'Method not allowed'
            ], 405);
        }
        break;

    case '/api/auth/register':
        if ($requestMethod == 'POST') {
            RegisteredUserController::store(json_decode(file_get_contents("php://input"), true));
        } else {
            Response::json([
                'success' => false,
                'message' => 'Method not allowed'
            ], 405);
        }
        break;

    case '/api/user':
        if ($requestMethod == 'GET') {
            UserController::index();
        } elseif ($requestMethod == 'PUT') {
            UserController::update(json_decode(file_get_contents("php://input"), true));
        } else {
            Response::json([
                'success' => false,
                'message' => 'Method not allowed'
            ], 405);
        }
        break;

    default:
        Response::json(['success' => false, 'message' => 'Not found'], 404);
}