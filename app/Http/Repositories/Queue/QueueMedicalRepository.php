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

    public function fetchByPatientId(string $patientId)
    {
        return QueueMedical::where('patient_id', $patientId)->first();
    }
}
