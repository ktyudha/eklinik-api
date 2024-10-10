<?php

namespace App\Http\Resources\Payment;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
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
            'payment_date' => $this->payment_date,
            'payment_method' => $this->payment_method,
            'status' => $this->status,
            'total_amount' => $this->total_amount,
            'patient' => $this->patient_id ? [
                'id' => $this->patient->id,
                'name' => $this->patient->name,
            ] : null,
            'medical' => $this->medical_id ? [
                'id' => $this->medical->id,
                'checkup_date' => $this->medical->checkup_date,
                'classification_name' => $this->medical->classification->name,
            ] : null,
            'recipe' => $this->recipe_id ? [
                'id' => $this->recipe->id,
                'description' => $this->recipe->description,
                'status' => $this->recipe->status,
            ] : null,

        ];
    }
}
