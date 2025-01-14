<?php

namespace App\Http\Controllers\Api\Medical;

use App\Http\Controllers\Controller;
use App\Http\Services\Medical\MedicalService;
use App\Http\Resources\Medical\MedicalResource;
use App\Http\Requests\Medical\MedicalCreateRequest;
use App\Http\Requests\Medical\MedicalUpdateRequest;
use App\Http\Requests\Pagination\PaginationRequest;

class PatientMedicalController extends Controller
{
    public function __construct(protected MedicalService $medicalService) {}

    public function index(PaginationRequest $request): array
    {
        return $this->medicalService->index($request);
    }
}
