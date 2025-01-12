<?php

namespace App\Http\Resources\Region;

use App\Models\Region\SubDistrict;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VillageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'postal_code' => $this->postal_code,
            'sub_district' => new SubDistrictResource($this->whenLoaded('subDistrict')),
            'city' => new CityResource($this->whenLoaded('subDistrict', fn($subDistrict) => $subDistrict->city)),
            'province' => new ProvinceResource($this->whenLoaded('subDistrict', fn($subDistrict) => $subDistrict->city?->province)),
        ];
    }
}
