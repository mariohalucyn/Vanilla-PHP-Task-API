<?php

namespace App\Middleware;

use Exception;

class AuthMiddleware {
    /**
     * @throws Exception
     */
    public static function getAuthenticatedUserId() {
        if (!isset($_SESSION['id'])) {
            throw new Exception('Unauthorized', 401);
        }
        return $_SESSION['id'];
    }
}