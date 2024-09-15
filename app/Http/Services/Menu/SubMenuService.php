<?php

namespace App\Http\Services\Menu;

use App\Http\Requests\Menu\SubMenuCreateRequest;
use App\Http\Requests\Menu\SubMenuUpdateRequest;
use App\Http\Repositories\Menu\SubMenuRepository;

class SubMenuService
{
    public function __construct(
        protected SubMenuRepository $subMenuRepository,
    ) {}

    public function index()
    {
        return $this->subMenuRepository->findAll();
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
