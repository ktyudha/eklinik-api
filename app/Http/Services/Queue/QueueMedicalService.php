<?php

namespace App\Http\Services\Queue;

use Illuminate\Support\Facades\DB;
use App\Enums\Role\Casemix\CasemixEnum;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Queue\QueueMedicalCreateRequest;
use App\Http\Requests\Queue\QueueMedicalUpdateRequest;
use App\Http\Repositories\Queue\QueueMedicalRepository;
use App\Http\Resources\Queue\QueueMedicalResource;

class QueueMedicalService
{
    public function __construct(
        protected QueueMedicalRepository $queueMedicalRepository,
    ) {}

    public function index()
    {
        $patientId = Auth::guard('patient-api')->user()->id;
        return $this->queueMedicalRepository->getByPatientId($patientId);
    }

    public function store(QueueMedicalCreateRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $queueMedical = $request->validated();
            $patientId = Auth::guard('patient-api')->user()->id;

            $existAwaiting = $this->queueMedicalRepository->isAwaitingByPatientId($patientId);

            if ($existAwaiting) {
                return response()->json(['message' => 'You already have an awaiting appointment.'], 400);
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

    public function show($id)
    {
        $patientId = Auth::guard('patient-api')->user()->id;
        return $this->queueMedicalRepository->findByIdPatientId($id, $patientId);
    }

    public function update($id, QueueMedicalUpdateRequest $request)
    {
        $patientId = Auth::guard('patient-api')->user()->id;
        $data = array_merge($request->validated(), ['patient_id' => $patientId]);
        return $this->queueMedicalRepository->update($id, $data);
    }

    public function destroy($id)
    {
        $this->queueMedicalRepository->delete($id);
    }

    public function cancel($id)
    {
        $patientId = Auth::guard('patient-api')->user()->id;

        $queue = $this->queueMedicalRepository->findByIdPatientId($id, $patientId)->exists();

        if (!$queue) {
            return response()->json(['error' => 'Unauthorized to cancel this appointment'], 403);
        }

        $cancelQueue = $this->queueMedicalRepository->update($id, ['status' => 'cancel']);
        return response()->json([
            'message' => 'success',
            'appointment' => new QueueMedicalResource($cancelQueue)
        ]);
    }

    public function getOneQueueActive()
    {
        $patientId = Auth::guard('patient-api')->user()->id;
        $existAwaiting = $this->queueMedicalRepository->isAwaitingByPatientId($patientId);

        if (!$existAwaiting) {
            return response()->json([
                'message' => 'No appointment found',
                'appointment' => null
            ]);
        }
        return response()->json([
            'message' => 'success',
            'appointment' => new QueueMedicalResource($existAwaiting)
        ]);
    }

    function handleCasemixType($status)
    {
        switch ($status) {
            case CasemixEnum::RAWAT_JALAN:
                return 'Q';

            case CasemixEnum::RAWAT_INAP:
                return 'I';

            case CasemixEnum::EMERGENCY:
                return 'E';
            default:
                return 'Q';
        }
    }
}
