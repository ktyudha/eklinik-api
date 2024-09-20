<?php

namespace App\Http\Repositories\Region;

use App\Models\Region\Country;
use App\Http\Repositories\BaseRepository;

class CountryRepository extends BaseRepository
{
    public function __construct(protected Country $country)
    {
        parent::__construct($country);
    }

    public function fetchNameByCode(string $code)
    {
        return $this->country->where('code', $code)->first()?->name;
    }
}
