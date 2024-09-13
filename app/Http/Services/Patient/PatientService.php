<?php

namespace App\Http\Services\Patient;

use Illuminate\Support\Facades\DB;
use App\Http\Repositories\Patient\PatientRepository;
use App\Http\Requests\Patient\PatientCreateRequest;
use App\Http\Requests\Patient\PatientUpdateRequest;

class PatientService
{
    public function __construct(
        protected PatientRepository $patientRepository,
    ) {}

    public function index()
    {
        return $this->patientRepository->findAll();
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
