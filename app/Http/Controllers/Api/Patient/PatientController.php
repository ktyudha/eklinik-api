<?php

namespace App\Http\Controllers\Api\Patient;

use App\Models\patient;
use Illuminate\Http\Request;
use App\Http\Services\Patient\PatientService;
use App\Http\Controllers\Controller;

class PatientController extends Controller
{
    public function __construct(protected PatientService $patientService) {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->patientService->index();
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
    public function show(patient $patient)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(patient $patient)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, patient $patient)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(patient $patient)
    {
        //
    }
}
