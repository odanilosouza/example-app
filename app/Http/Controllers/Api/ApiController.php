<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

abstract class ApiController extends Controller
{
    protected function success(array $data = [], string $message = 'Success', int $status = 200): JsonResponse
    {
        return response()->json(array_merge(['message' => $message], $data), $status);
    }

    protected function error(string $message = 'Error', int $status = 400, array $errors = []): JsonResponse
    {
        return response()->json(['message' => $message, 'errors' => $errors], $status);
    }
}
