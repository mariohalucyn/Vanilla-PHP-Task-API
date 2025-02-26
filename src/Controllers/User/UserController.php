<?php

namespace App\Controllers\User;

use App\Controllers\Controller;
use App\Http\Response;
use App\Middleware\AuthMiddleware;
use App\Models\User;
use Exception;

class UserController extends Controller {
    public function index(): void {
        try {
            $id = AuthMiddleware::getAuthenticatedUserId();

            $user = new User()->findById($id);

            Response::json([
                'success' => true,
                'message' => 'User found',
                'data' => $user
            ]);

        } catch (Exception $e) {
            Response::json([
                'success' => false,
                'message' => $e->getMessage()
            ], $e->getCode());
        }
    }

    public function update(array $request): void {
        try {
            $id = AuthMiddleware::getAuthenticatedUserId();

            $user = new User()->findById($id);

            // TODO: Handle other fields instead of first_name and last_name
            $firstName = isset($request['first_name']) ? trim($request['first_name']) : $user['first_name'];
            $lastName = isset($request['last_name']) ? trim($request['last_name']) : $user['last_name'];

            if ($firstName === '' || $lastName === '') {
                throw new Exception('Invalid input: first name and last name cannot be empty', 400);
            }

            if ($firstName === $user['first_name'] && $lastName === $user['last_name']) {
                Response::json([
                    'success' => true,
                    'message' => 'No changes made'
                ]);
            }

            new User()->update($id, $firstName, $lastName);

            Response::json([
                'success' => true,
                'message' => 'User updated successfully'
            ]);

        } catch (Exception $e) {
            Response::json([
                'success' => false,
                'message' => $e->getMessage()
            ], $e->getCode());
        }
    }
}
