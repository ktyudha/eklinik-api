<?php

namespace App\Http\Controllers\Api\Schedule;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Schedule\ScheduleRepository;

class ScheduleController extends Controller
{

    public function __construct(protected ScheduleRepository $scheduleRepository) {}

    public function index()
    {
        return response()->json([
            'message' => 'success',
            'schedules' => $this->scheduleRepository->findAll()
        ]);
    }
}
