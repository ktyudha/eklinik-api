<?php

namespace App\Http\Controllers\Api\Classification;

use App\Models\Classification;
use App\Http\Services\Classification\ClassificationService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClassificationController extends Controller
{

    public function __construct(protected ClassificationService $classificationService) {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->classificationService->index();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Classification $classification)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Classification $classification)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Classification $classification)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Classification $classification)
    {
        //
    }
}
