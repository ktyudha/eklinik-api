<?php

namespace App\Http\Controllers\Api\Medicine;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Medicine\MedicineService;
use App\Http\Resources\Medicine\MedicineResource;

class MedicineController extends Controller
{
    public function __construct(protected MedicineService $medicineService) {}

    public function index()
    {
        return response()->json([
            'message' => 'success',
            'medicines' => MedicineResource::collection($this->medicineService->index())
        ]);
    }

    public function store(Request $request)
    {
        return response()->json([
            'message' => 'success',
            'medicine' => new MedicineResource($this->medicineService->store($request))
        ]);
    }

    public function show($id)
    {
        return response()->json([
            'medicine' => new MedicineResource($this->medicineService->show($id))
        ]);
    }

    public function update(Request $request, $id)
    {
        return response()->json([
            'message' => 'success',
            'medicine' => new MedicineResource($this->medicineService->update($id, $request))
        ]);
    }

    public function destroy($id)
    {
        $this->medicineService->destroy($id);

        return response()->json([
            'message' => 'success'
        ]);
    }
}
