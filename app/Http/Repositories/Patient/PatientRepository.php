<?php

namespace App\Http\Repositories\Patient;

use App\Http\Repositories\BaseRepository;
use App\Models\Patient;

class PatientRepository extends BaseRepository
{
    public function __construct(protected Patient $patient)
    {
        parent::__construct($patient);
    }

    public function fetchByName(string $name)
    {
        return Patient::where('name', $name)->first();
    }

    public function findByUsername(string $username)
    {
        return $this->patient->where('username', $username)->first();
    }

    public function findLatest()
    {
        return $this->patient->latest()->first();
    }
}
