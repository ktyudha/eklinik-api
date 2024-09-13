<?php

namespace App\Http\Services\Medical;

use App\Http\Repositories\Medical\MedicalRepository;

class MedicalService
{
    public function __construct(
        protected MedicalRepository $medicalRepository,
    ) {}

    public function index()
    {
        return $this->medicalRepository->findAll();
    }
}
