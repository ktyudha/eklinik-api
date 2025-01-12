<?php

namespace App\Http\Repositories\Region;

use Illuminate\Http\Request;
use App\Models\Region\SubDistrict;
use App\Http\Repositories\BaseRepository;

class SubDistrictRepository extends BaseRepository
{
    public function __construct(protected SubDistrict $subDistrict)
    {
        parent::__construct($subDistrict);
    }

    public function filterByName(Request $request)
    {
        $filters = $request->only(['name']);
        return $this->subDistrict->filters($filters)->get();
    }
}
