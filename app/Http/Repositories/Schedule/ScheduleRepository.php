<?php

namespace App\Http\Repositories\Schedule;

use App\Http\Repositories\BaseRepository;
use App\Models\Schedule;

class ScheduleRepository extends BaseRepository
{
    public function __construct(protected Schedule $schedule)
    {
        parent::__construct($schedule);
    }
}
