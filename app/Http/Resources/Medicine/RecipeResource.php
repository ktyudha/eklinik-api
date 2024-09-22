<?php

namespace App\Http\Resources\Medicine;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RecipeResource extends JsonResource
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
            'description' => $this->description,
            'status' => $this->status,
            'amount' => $this->amount,
            'patient' => $this->patient_id ? [
                'id' => $this->patient->id,
                'name' => $this->patient->name,
            ] : null,
            'medical' => $this->medical_id ? [
                'id' => $this->medical->id,
                'checkup_date' => $this->medical->checkup_date,
                'classification_name' => $this->medical->classification->name,
            ] : null,
        ];
    }
}
