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
            // 'patient' => $this->patient_id ? new PatientResource($this->patient,) : null,
            'patient' => $this->patient_id ? [
                'id' => $this->patient->id,
                'name' => $this->patient->name,
                'mrn' => $this->patient->medical_record_number,
            ] : null,
            'submenu' => $this->submenu,
            'recipes' => $this->whenLoaded('recipes', function () {
                return RecipeResource::collection($this->recipes);
            }),
            // 'diagnosis' => $this->diagnosis,
            // 'complaints' => $this->complaints,
            // 'illness_duration_years' => $this->illness_duration_years,
            // 'illness_duration_months' => $this->illness_duration_months,
            // 'illness_duration_days' => $this->illness_duration_days,
            // 'medical_history' => $this->medical_history,
            // 'drug_allergies' => $this->drug_allergies,
            // 'food_allergies' => $this->food_allergies,
            // 'other_allergies' => $this->other_allergies,
            // 'sistole' => $this->sistole,
            // 'diastole' => $this->diastole,
            // 'height' => $this->height,
            // 'weight' => $this->weight,
            // 'pulse' => $this->pulse,
            // 'temperature' => $this->temperature,
            // 'pregnancy' => $this->pregnancy,
            // 'heart' => $this->heart,
            // 'other_checkup' => $this->other_checkup,
            // 'treatment' => $this->treatment,
            // 'recipe' => $this->recipe,
        ];
    }
}
