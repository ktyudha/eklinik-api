<?php

namespace App\Http\Controllers\Api\Queue;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pagination\PaginationRequest;
use App\Http\Services\Queue\AdminQueueMedicalService;
use App\Http\Resources\Queue\QueueMedicalResource;
use App\Http\Requests\Queue\QueueMedicalCreateRequest;
use App\Http\Requests\Queue\QueueMedicalUpdateRequest;

class AdminQueueMedicalController extends Controller
{
    public function __construct(protected AdminQueueMedicalService $adminQueueMedicalService) {}

    public function index(PaginationRequest $request): array
    {
        return $this->adminQueueMedicalService->index($request);
    }

    public function store(QueueMedicalCreateRequest $request)
    {
        return $this->adminQueueMedicalService->store($request);
    }

    public function show($id)
    {
        return response()->json([
            'appointment' => new QueueMedicalResource($this->adminQueueMedicalService->show($id))
        ]);
    }

    public function update(QueueMedicalUpdateRequest $request, $id)
    {
        return response()->json([
            'message' => 'success',
            'appointment' => new QueueMedicalResource($this->adminQueueMedicalService->update($id, $request))
        ]);
    }

    public function destroy($id)
    {
        $this->adminQueueMedicalService->destroy($id);

        return response()->json([
            'message' => 'success'
        ]);
    }
}
