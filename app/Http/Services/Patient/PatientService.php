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
        $filters = $request->only(['name']);

        $model = new Patient();

        return customPaginate(
            $model,
            [
                'property_name' => 'patients',
                'resource' => PatientResource::class,
                'sort_by' => 'latest',
                'sort_by_property' => 'id',
                'relations' => ['province', 'city', 'subDistrict'],
            ],
            $request->page_limit ?? 10,
            $filters
        );
    }

    public function store(PatientCreateRequest $request)
    {
        $dataPayload = $this->validateAndAddCredentials($request, $this->generatePasswordFromDateString($request->birth_date));

        // Menambahkan Payload Data
        $lastPatient = $this->patientRepository->findLatest();
        $dataPayload['medical_record_number'] = $lastPatient ? generateMedicalRecordNumber($lastPatient->medical_record_number) : generateMedicalRecordNumber(0);

        $createdData = $this->patientRepository->create($dataPayload);

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
