<?php

namespace App\Http\Controllers\Api\Patient;


use App\Http\Services\Patient\PatientService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Pagination\PaginationRequest;
use App\Http\Requests\Patient\PatientCreateRequest;
use App\Http\Requests\Patient\PatientUpdateRequest;
use App\Http\Resources\Patient\PatientResource;

class PatientController extends Controller
{
    public function __construct(protected PatientService $patientService) {}
    /**
     * Display a listing of the resource.
     */
    public function index(PaginationRequest $request): array
    {
        return $this->patientService->index($request);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PatientCreateRequest $request)
    {
        return response()->json([
            'message' => 'success',
            'patient' => new PatientResource($this->patientService->store($request))
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return response()->json([
            'patient' => new PatientResource($this->patientService->show($id))
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PatientUpdateRequest $request, $id)
    {
        return response()->json([
            'message' => 'success',
            'patient' => new PatientResource($this->patientService->update($id, $request))
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->patientService->destroy($id);

        return response()->json([
            'message' => 'success'
        ]);
    }
}
