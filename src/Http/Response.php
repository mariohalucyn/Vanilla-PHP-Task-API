<?php

namespace App\Http;

use JetBrains\PhpStorm\NoReturn;

class Response {
    #[NoReturn] public static function json($data, int $code = 200): void {
        header('Content-Type: application/json');
        http_response_code($code);
        echo json_encode($data);
        exit();
    }
}