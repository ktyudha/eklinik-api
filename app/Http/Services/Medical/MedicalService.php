<?php

namespace App\Http\Services\Medical;

use App\Models\Medical;
use App\Http\Requests\Medical\MedicalCreateRequest;
use App\Http\Requests\Medical\MedicalUpdateRequest;
use App\Http\Requests\Pagination\PaginationRequest;
use App\Http\Repositories\Medical\MedicalRepository;
use App\Http\Resources\Medical\MedicalResource;

class MedicalService
{
    public function __construct(
        protected MedicalRepository $medicalRepository,
    ) {}

    public function index(PaginationRequest $request): array
    {
        return customPaginate(
            new Medical(),
            [
                'property_name' => 'medicals',
                'resource' => MedicalResource::class,
                'sort_by' => 'oldest',
                'sort_by_property' => 'id',
                'relations' => ['patient', 'recipes'],
            ],
            $request->limit ?? 10
        );
    }

    public function store(MedicalCreateRequest $request)
    {
        return $this->medicalRepository->create($request->validated());
    }

    public function show($id)
    {
        return $this->medicalRepository->findById($id);
    }

    public function update($id, MedicalUpdateRequest $request)
    {
        return $this->medicalRepository->update($id, $request->validated());
    }

    public function destroy($id)
    {
        $this->medicalRepository->delete($id);
    }
}
