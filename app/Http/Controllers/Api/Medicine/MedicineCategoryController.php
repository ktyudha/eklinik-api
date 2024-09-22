<?php

namespace App\Http\Controllers\Api\Medicine;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Medicine\MedicineCategoryService;
use App\Http\Resources\Medicine\MedicineCategoryResource;

class MedicineCategoryController extends Controller
{
    public function __construct(protected MedicineCategoryService $medicineCategoryService) {}

    public function index()
    {
        return response()->json([
            'message' => 'success',
            'medicine_categories' => MedicineCategoryResource::collection($this->medicineCategoryService->index())
        ]);
    }

    public function store(Request $request)
    {
        return response()->json([
            'message' => 'success',
            'medicine_category' => new MedicineCategoryResource($this->medicineCategoryService->store($request))
        ]);
    }

    public function show($id)
    {
        return response()->json([
            'medicine_category' => new MedicineCategoryResource($this->medicineCategoryService->show($id))
        ]);
    }

    public function update(Request $request, $id)
    {
        return response()->json([
            'message' => 'success',
            'medicine_category' => new MedicineCategoryResource($this->medicineCategoryService->update($id, $request))
        ]);
    }

    public function destroy($id)
    {
        $this->medicineCategoryService->destroy($id);

        return response()->json([
            'message' => 'success'
        ]);
    }
}
