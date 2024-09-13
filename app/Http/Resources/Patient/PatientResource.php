<?php

namespace App\Http\Resources\Patient;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'no_medical_record' => $this->no_medical_record,
            'name' => $this->name,
            'date_of_birth' => $this->date_of_birth,
            'nik' => $this->nik,
            'education' => $this->education,
            'job' => $this->job,
            'gender' => $this->gender,
            'address' => $this->address,
        ];
    }
}
