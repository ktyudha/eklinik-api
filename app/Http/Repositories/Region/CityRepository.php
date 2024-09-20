<?php

namespace App\Http\Repositories\Region;

use App\Models\Region\City;
use App\Http\Repositories\BaseRepository;

class CityRepository extends BaseRepository
{
    public function __construct(protected City $city)
    {
        parent::__construct($city);
    }

    public function countAllCities()
    {
        return $this->city->count();
    }

    public function getCitiesByIds(array $cityIds)
    {
        return $this->city->whereIn('id', $cityIds)->with('province')->get();
    }
}
