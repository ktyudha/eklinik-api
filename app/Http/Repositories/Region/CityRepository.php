<?php

namespace App\Http\Repositories\Region;

use Illuminate\Http\Request;
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

    public function filterByName(Request $request)
    {
        $filters = $request->only(['name']);
        return $this->city->filters($filters)->get();
    }
}
