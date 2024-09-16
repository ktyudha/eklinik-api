<?php

namespace App\Http\Resources\Menu;

use App\Http\Resources\Classification\ClassificationResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MenuResource extends JsonResource
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
            'is_active' => $this->is_active,
            'classifications' => $this->whenLoaded('classifications', function () {
                return ClassificationResource::collection($this->classifications);
            }),
            'submenus' => $this->whenLoaded('submenus', function () {
                return SubMenuResource::collection($this->submenus);
            }),

        ];
    }
}
