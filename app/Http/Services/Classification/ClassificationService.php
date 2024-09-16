<?php

namespace App\Http\Services\Classification;

use App\Http\Requests\Classification\ClassificationCreateRequest;
use App\Http\Requests\Classification\ClassificationUpdateRequest;
use App\Http\Repositories\Classification\ClassificationRepository;

class ClassificationService
{
    public function __construct(
        protected ClassificationRepository $classificationRepository,
    ) {}

    public function index()
    {
        return $this->classificationRepository->findAll();
    }

    public function store(ClassificationCreateRequest $request)
    {
        return $this->classificationRepository->createClassificationWithMenu($request->validated());
    }

    public function show($id)
    {
        return $this->classificationRepository->findById($id, ['menus']);
    }

    public function update($id, ClassificationUpdateRequest $request)
    {
        return $this->classificationRepository->update($id, $request->validated());
    }

    public function destroy($id)
    {
        $this->classificationRepository->delete($id);
    }
}
