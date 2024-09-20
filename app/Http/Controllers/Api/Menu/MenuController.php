<?php

namespace App\Http\Controllers\Api\Menu;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pagination\PaginationRequest;
use App\Http\Requests\Menu\MenuCreateRequest;
use App\Http\Requests\Menu\MenuUpdateRequest;
use App\Http\Resources\Menu\MenuResource;
use App\Http\Services\Menu\MenuService;

class MenuController extends Controller
{
    public function __construct(protected MenuService $menuService) {}

    public function index(PaginationRequest $request): array
    {
        return $this->menuService->index($request);
    }

    public function store(MenuCreateRequest $request)
    {
        return response()->json([
            'message' => 'success',
            'menu' => new MenuResource($this->menuService->store($request))
        ]);
    }

    public function show($id)
    {
        return response()->json([
            'menu' => new MenuResource($this->menuService->show($id))
        ]);
    }

    public function update(MenuUpdateRequest $request, $id)
    {
        return response()->json([
            'message' => 'success',
            'menu' => new MenuResource($this->menuService->update($id, $request))
        ]);
    }

    public function destroy($id)
    {
        $this->menuService->destroy($id);

        return response()->json([
            'message' => 'success'
        ]);
    }
}
