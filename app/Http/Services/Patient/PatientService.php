<?php

namespace App\Http\Services\Patient;

use Carbon\Carbon;
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
                'relations' => ['province', 'city', 'subDistrict'],
            ],
            $request->limit ?? 10
        );
    }

    public function store(PatientCreateRequest $request)
    {
        $dataPayload = $this->validateAndAddCredentials($request, $this->generatePasswordFromDateString($request->birthdate));

        $createdData = $this->patientRepository->create($dataPayload);

        // $this->createStudentProfileTracer($request->profile_tracer_id, $createdData->id);

        return $createdData;
    }

    public function show($id)
    {
        return $this->patientRepository->findById($id, ['medicals']);
    }

    public function update($id, PatientUpdateRequest $request)
    {
        return $this->patientRepository->update($id, $request->validated());
    }

    public function destroy($id)
    {
        $this->patientRepository->delete($id);
    }

    private function generatePasswordFromDateString($dateString)
    {
        return str_replace('-', '', Carbon::parse($dateString)->format('dmY'));
    }

    private function validateAndAddCredentials($request, $password)
    {
        $validatedRequest = $request->validated();


        $validatedRequest['password'] = bcrypt($password);
        $validatedRequest['encrypted_password'] = encrypt($password);

        return $validatedRequest;
    }
}
