<?php

namespace App\Http\Resources\Queue;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QueueMedicalResource extends JsonResource
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
            'queue_number' => $this->queue_number,
            'queue_date' => $this->queue_date,
            'description' => $this->description,
            'status' => $this->status,
            'patient' => $this->patient_id ? [
                'id' => $this->patient->id,
                'name' => $this->patient->name,
            ] : null,
        ];
    }
}
