<?php

namespace App\Http\Resources\Patient;

use App\Http\Resources\Medical\MedicalResource;
use App\Http\Resources\Region\VillageResource;
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
            'medical_record_number' => $this->medical_record_number,
            'name' => $this->name,
            'username' => $this->username,
            'nik' => $this->nik,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'religion' => $this->religion,
            'gender' => $this->gender,
            'birth_place' => $this->birth_place,
            'birth_date' => $this->birth_date,
            'marital_status' => $this->marital_status,
            'education' => $this->education,
            'job' => $this->job,
            'province' => $this->province_id ? [
                'id' => $this->province->id,
                'name' => $this->province->name,
            ] : null,
            'city' => $this->city_id ? [
                'id' => $this->city->id,
                'name' => $this->city->name,
            ] : null,
            'sub_district' => $this->sub_district_id ? [
                'id' => $this->subDistrict->id,
                'name' => $this->subDistrict->name,
            ] : null,
            'village' => new VillageResource($this->village),
            'additional_address' => $this->additional_address,
            'medicals' => $this->whenLoaded('medicals', function () {
                return MedicalResource::collection($this->medicals);
            }),
        ];
    }
}
