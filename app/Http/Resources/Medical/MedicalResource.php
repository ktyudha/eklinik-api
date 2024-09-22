<?php

namespace App\Http\Resources\Medical;

use App\Http\Resources\Medicine\RecipeResource;
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
            'patient_id' => $this->patient_id,
            'classification_id' => $this->classification_id,
            'checkup_date' => $this->checkup_date,
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
