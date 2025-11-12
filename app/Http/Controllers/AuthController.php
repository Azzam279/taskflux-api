<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        return response()->json([
            'token' => config('app.mock_token')
        ], 200);
    }
}
