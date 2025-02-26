<?php

namespace App\Controllers\Auth;

use App\Controllers\Controller;
use App\Http\Response;
use App\Models\User;
use Exception;

class AuthenticatedSessionController extends Controller {
    public function store(array $request): void {
        try {
            if (empty($email) || empty($password)) {
                throw new Exception('All fields are required', 422);
            }

            $email = strtolower(trim($request['email']));
            $password = trim($request['password']);

            $user = new User()->findByEmail($email);
            if (!$user || !password_verify($password, $user['password'])) {
                throw new Exception('Invalid email or password', 422);
            }

            $_SESSION['id'] = $user['id'];

            Response::json([
                'success' => true,
                'message' => 'User logged in successfully',
            ]);
        } catch (Exception $e) {
            Response::json([
                'success' => false,
                'message' => $e->getMessage()
            ], $e->getCode());
        }
    }

    public function destroy(): void {
        if (!isset($_SESSION['id'])) {
            Response::json([
                'success' => false,
                'message' => 'No user is currently logged in'
            ], 401);
        }

        session_unset();
        session_destroy();

        Response::json([
            'success' => true,
            'message' => 'User logged out successfully'
        ]);
    }
}
