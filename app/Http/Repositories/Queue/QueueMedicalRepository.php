<?php

namespace App\Http\Repositories\Queue;

use App\Http\Repositories\BaseRepository;
use App\Models\Queue\QueueMedical;

class QueueMedicalRepository extends BaseRepository
{
    public function __construct(protected QueueMedical $queueMedical)
    {
        parent::__construct($queueMedical);
    }

    public function findByIdPatientId(
        string $queueMedicalId,
        string $patientId
    ) {
        return QueueMedical::where('patient_id', $patientId)->find($queueMedicalId);
    }
    public function getByPatientId(string $patientId)
    {
        return QueueMedical::where('patient_id', $patientId)->get();
    }

    public function incrementQueueNumber()
    {
        $today = now()->toDateString();

        $lastQueue = QueueMedical::whereDate('created_at', $today)
            ->orderBy('queue_number', 'desc')
            ->first();
        return $lastQueue ? $lastQueue->queue_number + 1 : 1;
    }
}
