<?php

namespace App\Http\Controllers\Api\Medical;

use App\Http\Controllers\Controller;
use App\Http\Services\Medical\PatientMedicalService;
use App\Http\Requests\Pagination\PaginationRequest;

class PatientMedicalController extends Controller
{
    public function __construct(protected PatientMedicalService $patientMedicalService) {}

    public function index(PaginationRequest $request): array
    {
        return $this->patientMedicalService->index($request);
    }
}
