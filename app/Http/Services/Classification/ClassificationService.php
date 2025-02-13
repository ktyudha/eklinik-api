<?php

namespace App\Http\Services\Classification;

use App\Models\Classification;
use App\Http\Requests\Pagination\PaginationRequest;
use App\Http\Requests\Classification\ClassificationCreateRequest;
use App\Http\Requests\Classification\ClassificationUpdateRequest;
use App\Http\Repositories\Classification\ClassificationRepository;
use App\Http\Resources\Classification\ClassificationResource;

class ClassificationService
{
    public function __construct(
        protected ClassificationRepository $classificationRepository,
    ) {}

    public function index(PaginationRequest $request): array
    {
        $filters = $request->only(['name']);
        return customPaginate(
            new Classification(),
            [
                'property_name' => 'classifications',
                'resource' => ClassificationResource::class,
                'sort_by' => 'oldest',
                'sort_by_property' => 'id',
                'relations' => ['menus'],
            ],
            $request->limit ?? 10,
            $filters
        );
    }

    public function store(ClassificationCreateRequest $request)
    {
        return $this->classificationRepository->createClassificationWithMenu($request->validated());
    }

    public function show($id)
    {
        return $this->classificationRepository->findById($id, ['menus.submenus']);
    }

    public function update($id, ClassificationUpdateRequest $request)
    {
        return $this->classificationRepository->updateClassificationWithMenu($id, $request->validated());
    }

    public function destroy($id)
    {
        $this->classificationRepository->delete($id);
    }
}
