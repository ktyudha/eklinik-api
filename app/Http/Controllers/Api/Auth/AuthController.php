<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Services\Auth\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(
        protected AuthService $authService
    ) {}

    public function login(LoginRequest $request)
    {
        $user = $this->authService->centralizedLogin($request);

        if (gettype($user) == 'string') {
            return response()->json([
                'message' => $user
            ], 400);
        }

        if ($user instanceof JsonResponse) {
            return $user;
        }

        return response()->json([
            'user' => $user['user'],
            'role' => $user['role'],
            'token' => $user['user']->createToken('EklinikToken')->accessToken,
            'created_at' => $user['user']->created_at->format('d-m-Y H:i:s'),
            'updated_at' => $user['user']->updated_at->format('d-m-Y H:i:s'),
        ]);
    }

    public function logout()
    {
        $this->authService->centralizedLogout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function user()
    {
        $user = $this->authService->getAuthenticatedUser();

        return response()->json([
            'user' => $user['user'],
            'role' => $user['role'],
            'created_at' => $user['user']->created_at->format('d-m-Y H:i:s'),
            'updated_at' => $user['user']->updated_at->format('d-m-Y H:i:s'),
        ]);
    }
}
