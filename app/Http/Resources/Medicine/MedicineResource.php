<?php

namespace App\Http\Resources\Medicine;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MedicineResource extends JsonResource
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
            'name' => $this->name,
            'description' => $this->description,
            'expired_date' => $this->expired_date,
            'unit' => $this->unit,
            'stock' => $this->stock,
            'price' => $this->price,
            'medicine_category' => $this->medicine_category_id ? [
                'id' => $this->medicineCategory->id,
                'name' => $this->medicineCategory->name,
                'description' => $this->medicineCategory->description,
            ] : null,
        ];
    }
}
