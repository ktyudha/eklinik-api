<?php

namespace App\Http\Repositories\User;

use App\Http\Repositories\BaseRepository;
use App\Models\User;

class UserRepository extends BaseRepository
{
    public function __construct(protected User $user)
    {
        parent::__construct($user);
    }

    public function fetchByUsername(string $userName)
    {
        return User::where('username', $userName)->first();
    }
}
