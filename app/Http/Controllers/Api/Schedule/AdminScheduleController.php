<?php

namespace App\Http\Controllers\Api\Schedule;

use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;
use App\Http\Resources\Schedule\ScheduleResource;
use App\Http\Repositories\Schedule\ScheduleRepository;
use App\Http\Requests\Schedule\ScheduleRequest;

class AdminScheduleController extends Controller
{

    public function __construct(protected ScheduleRepository $scheduleRepository) {}

    public function index()
    {
        return response()->json([
            'message' => 'success',
            'schedules' => ScheduleResource::collection($this->scheduleRepository->findAll())
        ]);
    }

    public function store(ScheduleRequest $request)
    {
        return $this->scheduleRepository->create($request->validated());
    }

    public function show($id)
    {
        return response()->json([
            'schedule' => new ScheduleResource($this->scheduleRepository->findById($id))
        ]);
    }

    public function update(ScheduleRequest $request, $id)
    {
        return response()->json([
            'message' => 'success',
            'schedule' => new ScheduleResource($this->scheduleRepository->update($id, $request->validated()))
        ]);
    }

    public function destroy($id)
    {
        $this->scheduleRepository->delete($id);

        return response()->json([
            'message' => 'success'
        ]);
    }
}
