<?php

namespace App\Http\Resources\Region;

use Illuminate\Http\Request;
use App\Http\Resources\Region\CityResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ProvinceResource extends JsonResource
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
            'cities' => collect($this->cities)->map(function ($city) {
                return [
                    'id' => $city->id,
                    'name' => $city->name,
                ];
            }),
        ];
    }
}
