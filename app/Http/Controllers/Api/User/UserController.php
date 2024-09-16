<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Services\User\UserService;
use App\Http\Resources\User\UserResource;
use App\Http\Requests\User\UserCreateRequest;
use App\Http\Requests\User\UserUpdateRequest;


class UserController extends Controller
{
    public function __construct(protected UserService $userService) {}

    public function store(UserCreateRequest $request)
    {
        return response()->json([
            'message' => 'success',
            'user' => new UserResource($this->userService->store($request))
        ]);
    }

    public function update(UserUpdateRequest $request, $id)
    {
        return response()->json([
            'message' => 'success',
            'menu' => new UserResource($this->userService->update($id, $request))
        ]);
    }
}
