<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
// use App\Http\Requests\Agency\SubAgencyCreateRequest;
// use App\Http\Requests\Agency\SubAgencyUpdateRequest;
use App\Http\Services\User\UserService;
use Illuminate\Support\Facades\Request;

// use App\Http\Requests\Pagination\PaginationRequest;
// use App\Http\Resources\Agency\SubAgencyResource;

class UserController extends Controller
{
    public function __construct(protected UserService $userService) {}

    public function index(Request $request)
    {
        return $this->userService->index();
    }
}
