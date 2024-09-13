<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Services\Auth\AdminAuthService;
use Illuminate\Http\JsonResponse;

class AdminAuthController extends Controller
{
    public function __construct(protected AdminAuthService $adminAuthService) {}

    public function login(LoginRequest $request): JsonResponse
    {
        $user = $this->adminAuthService->login($request);

        if ($user instanceof JsonResponse) {
            return $user;
        }

        return response()->json([
            'user' => $user['user'],
            'role' => $user['role'],
            'token' => $user['user']->createToken('TracerStudyToken')->accessToken,
            'created_at' => $user['user']->created_at->format('d-m-Y H:i:s'),
            'updated_at' => $user['user']->updated_at->format('d-m-Y H:i:s'),
        ]);
    }

    public function logout()
    {
        $this->adminAuthService->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function user()
    {
        $user = $this->adminAuthService->getAuthenticatedUser();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return response()->json([
            'user' => $user['user'],
            'role' => $user['role'],
            'created_at' => $user['user']->created_at->format('d-m-Y H:i:s'),
            'updated_at' => $user['user']->updated_at->format('d-m-Y H:i:s'),
        ]);
    }
}
