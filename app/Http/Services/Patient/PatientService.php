<?php

namespace App\Http\Services\Patient;

use Illuminate\Support\Facades\DB;
use App\Http\Repositories\Patient\PatientRepository;
use App\Http\Requests\Patient\PatientCreateRequest;
use App\Http\Requests\Pagination\PaginationRequest;
use App\Http\Requests\Patient\PatientUpdateRequest;
use App\Http\Resources\Patient\PatientResource;
use App\Models\Patient;

class PatientService
{
    public function __construct(
        protected PatientRepository $patientRepository,
    ) {}

    public function index(PaginationRequest $request): array
    {
        return customPaginate(
            new Patient(),
            [
                'property_name' => 'patients',
                'resource' => PatientResource::class,
                'sort_by' => 'oldest',
                'sort_by_property' => 'id',
                'relations' => ['medicals'],
            ],
            $request->limit ?? 10
        );
    }

    public function store(PatientCreateRequest $request)
    {
        return $this->patientRepository->create($request->validated());
    }

    public function show($id)
    {
        return $this->patientRepository->findById($id);
    }

    public function update($id, PatientUpdateRequest $request)
    {
        return $this->patientRepository->update($id, $request->validated());
    }

    public function destroy($id)
    {
        $this->patientRepository->delete($id);
    }
}
