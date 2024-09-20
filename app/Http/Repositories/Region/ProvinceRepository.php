<?php

namespace App\Http\Repositories\Region;

use App\Models\Region\Province;
use App\Http\Repositories\BaseRepository;

class ProvinceRepository extends BaseRepository
{
    public function __construct(protected Province $province)
    {
        parent::__construct($province);
    }

    public function countProvinceCities(string $provinceId)
    {
        return $this->province->where('id', $provinceId)->first()->cities->count();
    }
}
