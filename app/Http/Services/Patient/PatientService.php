<?php

namespace App\Http\Services\Patient;

use App\Http\Repositories\Patient\PatientRepository;

class PatientService
{
    public function __construct(
        protected PatientRepository $patientRepository,
    ) {}

    public function index()
    {
        return $this->patientRepository->findAll();
    }
}
