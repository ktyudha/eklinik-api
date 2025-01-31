<?php

namespace App\Http\Repositories\Queue;

use App\Http\Repositories\BaseRepository;
use App\Models\Queue\QueueMedical;
use Carbon\Carbon;

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
        return $this->queueMedical::where('patient_id', $patientId)->find($queueMedicalId);
    }

    public function getByPatientId(string $patientId)
    {
        return $this->queueMedical::where('patient_id', $patientId)->get();
    }

    public function isAwaitingByPatientId($patientId)
    {
        return $this->queueMedical::where('patient_id', $patientId)->whereDate('created_at', Carbon::today())
            ->where('status', 'waiting')
            ->exists();;
    }

    public function incrementQueueNumber()
    {
        $today = now()->toDateString();

        $lastQueue = $this->queueMedical::whereDate('created_at', $today)
            ->orderBy('queue_number', 'desc')
            ->first();

        if ($lastQueue) {
            preg_match('/\d+/', $lastQueue->queue_number, $matches);
            $lastNumber = (int)$matches[0];
            $nextNumber = $lastNumber + 1;
            return 'Q' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
        } else {
            return 'Q001';
        }
    }
}
