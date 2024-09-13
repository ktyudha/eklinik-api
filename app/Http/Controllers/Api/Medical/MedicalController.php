<?php

namespace App\Http\Controllers\Api\Medical;

use App\Models\Medical;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Services\Medical\MedicalService;

class MedicalController extends Controller
{
    public function __construct(protected MedicalService $medicalService) {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->medicalService->index();
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
    public function show(Medical $medical)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Medical $medical)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Medical $medical)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Medical $medical)
    {
        //
    }
}
