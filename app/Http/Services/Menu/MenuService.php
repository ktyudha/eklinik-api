<?php

namespace App\Http\Services\Menu;

use App\Models\Menu\Menu;
use App\Http\Resources\Menu\MenuResource;
use App\Http\Requests\Menu\MenuCreateRequest;
use App\Http\Requests\Menu\MenuUpdateRequest;
use App\Http\Repositories\Menu\MenuRepository;
use App\Http\Requests\Pagination\PaginationRequest;

class MenuService
{
    public function __construct(
        protected MenuRepository $menuRepository,
    ) {}

    public function index(PaginationRequest $request): array
    {
        // $query = Menu::where('is_active', 1);
        $filters = $request->only(['name']);
        $model = new Menu();
        return customPaginate(
            // $query,
            $model,
            [
                'property_name' => 'menus',
                'resource' => MenuResource::class,
                'sort_by' => 'oldest',
                'sort_by_property' => 'id',
                'relations' => ['submenus', 'classifications'],
            ],
            $request->limit ?? 10,
            $filters
        );
    }

    public function store(MenuCreateRequest $request)
    {
        return $this->menuRepository->create($request->validated());
    }

    public function show($id)
    {
        return $this->menuRepository->findById($id, ['classifications', 'submenus']);
    }

    public function update($id, MenuUpdateRequest $request)
    {
        return $this->menuRepository->update($id, $request->validated());
    }

    public function destroy($id)
    {
        $this->menuRepository->delete($id);
    }
}
