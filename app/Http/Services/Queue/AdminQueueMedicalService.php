<?php

namespace App\Http\Services\Queue;

use Illuminate\Support\Facades\DB;
use App\Enums\Role\Casemix\CasemixEnum;
use Illuminate\Support\Facades\Auth;
use App\Models\Queue\QueueMedical;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Queue\QueueMedicalUpdateRequest;
use App\Http\Repositories\Queue\QueueMedicalRepository;
use App\Http\Resources\Queue\QueueMedicalResource;
use App\Http\Requests\Pagination\PaginationRequest;
use Illuminate\Http\Request;

class AdminQueueMedicalService
{
    public function __construct(
        protected QueueMedicalRepository $queueMedicalRepository,
    ) {}

    public function index(PaginationRequest $request): array
    {
        Validator::make($request->only(['status', 'patient_name', 'queue_date', 'complaint']), [
            'status' => 'nullable|in:waiting,cancel,finished',
            'patient_name' => 'nullable|string',
            'queue_date' => 'nullable|datetime',
            'complaint' => 'nullable|string',
        ])->validate();

        $model = new QueueMedical();

        return customPaginate(
            $model,
            [
                'property_name' => 'appointments',
                'resource' => QueueMedicalResource::class,
                'order_direction' => 'desc',
                'relations' => ['patient'],
            ],
            $request->page_limit ?? 10,
            $request->only(['status', 'patient_name', 'queue_date', 'complaint'])
        );
    }

    public function store(Request $request)
    {
        return DB::transaction(function () use ($request) {
            $queueMedical = $request->validate([
                'patient_id' => 'required|string|exists:patients,id',
                'description' => 'required|string'
            ]);

            $patientId = $request->patient_id;
            $existAwaiting = $this->queueMedicalRepository->isAwaiting($patientId);

            if ($existAwaiting) {
                return response()->json(['message' => 'Patient already have an awaiting appointment.'], 400);
            }

            $queueNumber = $this->queueMedicalRepository->incrementQueueNumber();

            $queueMedical['patient_id'] = $patientId;
            $queueMedical['queue_date'] = now();
            $queueMedical['queue_number'] = $queueNumber;

            return response()->json([
                'message' => 'success',
                'appointment' => new QueueMedicalResource($this->queueMedicalRepository->create($queueMedical))
            ]);
        });
    }

    public function show($queueId)
    {
        return $this->queueMedicalRepository->findById($queueId, ['patient']);
    }

    public function update($id, QueueMedicalUpdateRequest $request)
    {
        return $this->queueMedicalRepository->update($id, $request->validated());
    }

    public function destroy($queueId)
    {
        $this->queueMedicalRepository->delete($queueId);
    }
}
