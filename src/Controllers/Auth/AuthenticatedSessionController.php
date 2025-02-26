<?php


namespace App\Controllers\Auth;

use App\Controllers\Controller;
use App\Http\Response;
use App\Models\User;
use Exception;
use JetBrains\PhpStorm\NoReturn;

class AuthenticatedSessionController extends Controller {
    public function store(array $request): void {
        try {
            $email = strtolower(trim($request['email'] ?? ''));
            $password = trim($request['password'] ?? '');

            if (empty($email) || empty($password)) {
                throw new Exception('All fields are required', 422);
            }

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

    #[NoReturn] public function destroy(): void {
        session_unset();
        session_destroy();

        Response::json([
            'success' => true,
            'message' => 'User logged out successfully'
        ]);
    }
}
