<?php

namespace App\Http\Controllers\Api\Classification;

use Illuminate\Http\Request;
use App\Models\Classification;
use App\Http\Controllers\Controller;
use App\Http\Services\Classification\ClassificationService;
use App\Http\Resources\Classification\ClassificationResource;
use App\Http\Requests\Classification\ClassificationCreateRequest;
use App\Http\Requests\Classification\ClassificationUpdateRequest;

class ClassificationController extends Controller
{

    public function __construct(protected ClassificationService $classificationService) {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'message' => 'success',
            'classifications' => ClassificationResource::collection($this->classificationService->index())
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClassificationCreateRequest $request)
    {
        return response()->json([
            'message' => 'success',
            'classification' => new ClassificationResource($this->classificationService->store($request))
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return response()->json([
            'classification' => new ClassificationResource($this->classificationService->show($id))
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ClassificationUpdateRequest $request, $id)
    {
        return response()->json([
            'message' => 'success',
            'classification' => new ClassificationResource($this->classificationService->update($id, $request))
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->classificationService->destroy($id);

        return response()->json([
            'message' => 'success'
        ]);
    }
}
