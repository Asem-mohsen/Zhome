<?php

namespace App\Traits;

trait ApiResponse
{
    public function error(array $errors, string $message, int $statusCode = 404)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => (object) [],
            'error' => (object) $errors,
        ], $statusCode);

    }
}
