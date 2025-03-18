<?php

namespace App\Http\Resources\Medical;

use App\Http\Resources\Classification\ClassificationResource;
use App\Http\Resources\Medicine\RecipeResource;
use App\Http\Resources\Patient\PatientResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MedicalResource extends JsonResource
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
            'checkup_date' => $this->checkup_date,
            'classification' => $this->classification_id ? [
                'id' => $this->classification->id,
                'name' => $this->classification->name,
            ] : null,
            'patient' => $this->patient_id ? new PatientResource($this->patient,) : null,
            // 'patient' => $this->patient_id ? [
            //     'id' => $this->patient->id,
            //     'name' => $this->patient->name,
            //     'mrn' => $this->patient->medical_record_number,
            // ] : null,
            'submenu' => $this->submenu,
            'recipes' => $this->whenLoaded('recipes', function () {
                return RecipeResource::collection($this->recipes);
            }),

        ];
    }
}
