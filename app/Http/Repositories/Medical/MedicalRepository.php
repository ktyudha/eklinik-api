<?php

namespace App\Http\Repositories\Medical;

use App\Http\Repositories\BaseRepository;
use App\Models\Medical;

class MedicalRepository extends BaseRepository
{
    public function __construct(protected Medical $medical)
    {
        parent::__construct($medical);
    }

    public function fetchByPatientId(string $patientId)
    {
        return Medical::where('patient_id', $patientId)->first();
    }
}
