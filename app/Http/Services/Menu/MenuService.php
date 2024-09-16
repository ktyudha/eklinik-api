<?php

namespace App\Http\Services\Menu;

use App\Http\Repositories\Menu\MenuRepository;
use App\Http\Requests\Menu\MenuCreateRequest;
use App\Http\Requests\Menu\MenuUpdateRequest;

class MenuService
{
    public function __construct(
        protected MenuRepository $menuRepository,
    ) {}

    public function index()
    {
        return $this->menuRepository->findAll();
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
