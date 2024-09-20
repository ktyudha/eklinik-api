<?php

namespace App\Http\Repositories\Region;

use App\Models\Region\SubDistrict;
use App\Http\Repositories\BaseRepository;

class SubDistrictRepository extends BaseRepository
{
    public function __construct(protected SubDistrict $subDistrict)
    {
        parent::__construct($subDistrict);
    }
}
