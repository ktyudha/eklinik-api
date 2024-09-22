<?php

namespace App\Http\Services\Menu;

use App\Models\Menu\SubMenu;
use App\Http\Requests\Pagination\PaginationRequest;
use App\Http\Resources\Menu\SubMenuResource;
use App\Http\Requests\Menu\SubMenuCreateRequest;
use App\Http\Requests\Menu\SubMenuUpdateRequest;
use App\Http\Repositories\Menu\SubMenuRepository;

class SubMenuService
{
    public function __construct(
        protected SubMenuRepository $subMenuRepository,
    ) {}

    public function index(PaginationRequest $request): array
    {
        return customPaginate(
            new SubMenu(),
            [
                'property_name' => 'submenus',
                'resource' => SubMenuResource::class,
                'sort_by' => 'oldest',
                'sort_by_property' => 'id',
            ],
            $request->limit ?? 10
        );
    }

    public function store(SubMenuCreateRequest $request)
    {
        return $this->subMenuRepository->create($request->validated());
    }

    public function show($id)
    {
        return $this->subMenuRepository->findById($id);
    }

    public function update($id, SubMenuUpdateRequest $request)
    {
        return $this->subMenuRepository->update($id, $request->validated());
    }

    public function destroy($id)
    {
        $this->subMenuRepository->delete($id);
    }
}
