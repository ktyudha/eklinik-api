<?php

namespace App\Http\Controllers\Api\Medical;

use App\Http\Controllers\Controller;
use App\Http\Services\Medical\MedicalService;
use App\Http\Resources\Medical\MedicalResource;
use App\Http\Requests\Medical\MedicalCreateRequest;
use App\Http\Requests\Medical\MedicalUpdateRequest;

class MedicalController extends Controller
{
    public function __construct(protected MedicalService $medicalService) {}

    public function index()
    {
        return response()->json([
            'message' => 'success',
            'medical' => MedicalResource::collection($this->medicalService->index())
        ]);
    }

    public function store(MedicalCreateRequest $request)
    {
        return response()->json([
            'message' => 'success',
            'medical' => new MedicalResource($this->medicalService->store($request))
        ]);
    }

    public function show($id)
    {
        return response()->json([
            'menu' => new MedicalResource($this->medicalService->show($id))
        ]);
    }

    public function update(MedicalUpdateRequest $request, $id)
    {
        return response()->json([
            'message' => 'success',
            'medical' => new MedicalResource($this->medicalService->update($id, $request))
        ]);
    }

    public function destroy($id)
    {
        $this->medicalService->destroy($id);

        return response()->json([
            'message' => 'success'
        ]);
    }
}
