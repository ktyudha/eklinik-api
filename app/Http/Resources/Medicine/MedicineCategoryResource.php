<?php

namespace App\Http\Resources\Medicine;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MedicineCategoryResource extends JsonResource
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
            // 'medicines' => $this->whenLoaded('medicines', function () {
            //     return MedicineResource::collection($this->medicines);
            // }),
        ];
    }
}
