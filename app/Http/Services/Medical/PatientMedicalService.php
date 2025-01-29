<?php

namespace App\Http\Services\Medical;

use App\Models\Medical;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Medical\MedicalCreateRequest;
use App\Http\Requests\Medical\MedicalUpdateRequest;
use App\Http\Requests\Pagination\PaginationRequest;
use App\Http\Repositories\Medical\MedicalRepository;
use App\Http\Resources\Medical\MedicalResource;

class PatientMedicalService
{
    public function __construct(
        protected MedicalRepository $medicalRepository,
    ) {}

    public function index(PaginationRequest $request): array
    {
        // $filters = $request->only(['name']);

        $patientId = auth('patient-api')->user()->id;
        $model = Medical::where('patient_id', $patientId);

        return customPaginate(
            $model,
            [
                'property_name' => 'medicals',
                'resource' => MedicalResource::class,
                'sort_by' => 'latest',
                'sort_by_property' => 'id',
                // 'order_direction' => 'asc',
                'relations' => ['patient', 'recipes'],
            ],
            $request->page_limit ?? 10,
            // $filters
        );
    }
}
