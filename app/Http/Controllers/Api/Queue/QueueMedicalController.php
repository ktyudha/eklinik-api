<?php

namespace App\Http\Controllers\Api\Queue;

use App\Http\Controllers\Controller;
use App\Http\Services\Queue\QueueMedicalService;
use App\Http\Resources\Queue\QueueMedicalResource;
use App\Http\Requests\Queue\QueueMedicalCreateRequest;
use App\Http\Requests\Queue\QueueMedicalUpdateRequest;

class QueueMedicalController extends Controller
{
    public function __construct(protected QueueMedicalService $queueMedicalService) {}

    public function index()
    {
        return response()->json([
            'message' => 'success',
            'appointments' => QueueMedicalResource::collection($this->queueMedicalService->index())
        ]);
    }

    public function store(QueueMedicalCreateRequest $request)
    {
        return response()->json([
            'message' => 'success',
            'appointment' => new QueueMedicalResource($this->queueMedicalService->store($request))
        ]);
    }

    public function show($id)
    {
        return response()->json([
            'appointment' => new QueueMedicalResource($this->queueMedicalService->show($id))
        ]);
    }

    public function update(QueueMedicalUpdateRequest $request, $id)
    {
        return response()->json([
            'message' => 'success',
            'appointment' => new QueueMedicalResource($this->queueMedicalService->update($id, $request))
        ]);
    }

    public function destroy($id)
    {
        $this->queueMedicalService->destroy($id);

        return response()->json([
            'message' => 'success'
        ]);
    }
}
