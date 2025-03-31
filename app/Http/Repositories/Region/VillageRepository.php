<?php

namespace App\Http\Repositories\Region;

use Illuminate\Http\Request;
use App\Models\Region\Village;
use App\Http\Repositories\BaseRepository;
use App\Http\Resources\Region\VillageResource;

class VillageRepository extends BaseRepository
{
    public function __construct(protected Village $village)
    {
        parent::__construct($village);
    }

    public function findByName(string $villageName, array $relations = [])
    {
        return $this->village::where('name', $villageName)->with($relations)->first();
    }

    public function filterByName(Request $request, array $relations = [])
    {
        $filters = $request->only(['name']);
        return $this->village->filters($filters)->with($relations)->get();
    }
}
