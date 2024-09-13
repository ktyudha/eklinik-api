<?php

namespace App\Http\Services\Auth;

use App\Enums\Role\RoleEnum;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\User\UserResource;
use Illuminate\Support\Facades\Validator;
use App\Http\Repositories\User\UserRepository;
use App\Http\Requests\Auth\LoginRequest;

class AdminAuthService
{
    public function __construct(
        protected UserRepository $userRepository
    ) {}

    public function login(LoginRequest $request)
    {
        Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string',
        ])->validate();

        if (Auth::guard('web')->attempt($request->only('username', 'password'), true)) {
            return $this->adminCredential($request->username);
        }

        return $this->handleFailedLogin();
    }

    public function getAuthenticatedUser()
    {
        if (Auth::guard('api')->check()) {
            $user = Auth::guard('api')->user();
            $role = strtolower(class_basename($user));
            $role = $role === 'user' ? 'admin' : $role;
            $user->role = $role;

            return $this->adminCredential($user->username);
        }
    }

    public function logout()
    {
        if (Auth::guard('api')->check()) {
            $user = Auth::guard('api')->user();
            $user->token()->revoke();
        }
    }

    private function adminCredential(string $username)
    {
        $user = $this->userRepository->findByUsername($username);

        return [
            'user' => new UserResource($user),
            'role' => RoleEnum::ADMIN,
        ];
    }

    private function handleFailedLogin(): JsonResponse
    {
        return response()->json([
            'message' => 'Kredensial anda tidak ditemukan di database kami',
        ], 401);
    }
}
