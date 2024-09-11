<?php

namespace App\Http\Services\User;

use App\Http\Repositories\User\UserRepository;

class UserService
{
    public function __construct(
        protected UserRepository $userRepository,
    ) {}

    public function index()
    {
        return $this->userRepository->findAll();
    }
}
