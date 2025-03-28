<?php

namespace App\Http\Resources\Classification;

use App\Http\Resources\Menu\MenuResource;
use App\Http\Resources\Menu\SubMenuResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClassificationResource extends JsonResource
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
            'price' => $this->price,
            'menus' => $this->whenLoaded('menus', function () {
                return MenuResource::collection($this->menus);
            }),
        ];
    }
}
