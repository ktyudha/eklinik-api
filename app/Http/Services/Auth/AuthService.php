<?php

namespace App\Http\Services\Auth;

use App\Enums\Role\RoleEnum;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Repositories\Patient\PatientRepository;
use App\Http\Resources\Patient\PatientCredentialsResource;
use Illuminate\Http\JsonResponse;

class AuthService
{
    private const WEB_GUARDS = ['patient-web'];
    private const API_GUARDS = ['patient-api'];

    public function __construct(
        protected PatientRepository $patientRepository,
    ) {}

    public function centralizedLogin(LoginRequest $request)
    {
        $credentials = $request->only(['username', 'password']);

        foreach (self::WEB_GUARDS as $guard) {
            if (Auth::guard($guard)->attempt($credentials, true)) {
                return $this->handleSuccessfulLogin($guard, $credentials['username']);
            }
        }

        return $this->handleFailedLogin();
    }

    public function centralizedLogout()
    {
        foreach (self::API_GUARDS as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::guard($guard)->user();
                $user->token()->revoke();
            }
        }
    }

    public function getAuthenticatedUser()
    {
        foreach (self::API_GUARDS as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::guard($guard)->user();
                $role = strtolower(preg_replace('/(?<!^)[A-Z]/', '-$0', class_basename($user)));
                $role = $role === 'user' ? 'admin' : $role;
                $user->role = $role;
                return $this->loginByRole($role, $user->username);
            }
        }
    }

    private function handleSuccessfulLogin($guard, $username)
    {
        switch ($guard) {
            case 'patient-web':
                return $this->loginByRole(RoleEnum::PATIENT, $username);
        }
    }

    private function loginByRole($role, $username)
    {
        switch ($role) {
            case RoleEnum::PATIENT:
                return $this->patientLogin($username);
        }
    }

    private function patientLogin(string $username): string|array
    {
        return [
            'user' => new PatientCredentialsResource($this->patientRepository->findByUsername($username)->load('medicals')),
            'role' => RoleEnum::PATIENT,
        ];
    }


    private function handleFailedLogin(): JsonResponse
    {
        return response()->json([
            'message' => 'Kredensial anda tidak ditemukan di database kami',
        ], 401);
    }
}
