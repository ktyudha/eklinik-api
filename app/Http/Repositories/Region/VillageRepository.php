<?php

namespace App\Http\Repositories\Region;

use App\Models\Region\Village;
use App\Http\Repositories\BaseRepository;

class VillageRepository extends BaseRepository
{
    public function __construct(protected Village $village)
    {
        parent::__construct($village);
    }
}
