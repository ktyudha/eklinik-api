<?php

namespace App\Http\Services\Queue;

use App\Enums\Role\Casemix\CasemixEnum;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Queue\QueueMedicalCreateRequest;
use App\Http\Requests\Queue\QueueMedicalUpdateRequest;
use App\Http\Repositories\Queue\QueueMedicalRepository;

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
        $queueMedical = $request->validated();
        // $patientId = Auth::guard('patient-api')->user()->id;
        // $queue_number = 'Q' . $this->queueMedicalRepository->incrementQueueNumber();
        $queueMedical['patient_id'] = Auth::guard('patient-api')->user()->id;
        $queueMedical['queue_number'] = 'Q' . $this->queueMedicalRepository->incrementQueueNumber();

        // $data = array_merge($request->validated(), ['patient_id' => $patientId, 'queue_number' => $queue_number]);

        return $this->queueMedicalRepository->create($queueMedical);
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

    public function handleCasemixType($status)
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
