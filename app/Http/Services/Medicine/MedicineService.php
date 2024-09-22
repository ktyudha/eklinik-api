<?php

namespace App\Http\Services\Medicine;

use App\Http\Repositories\Medicine\MedicineRepository;
use Illuminate\Http\Request;

class MedicineService
{
    public function __construct(
        protected MedicineRepository $medicineRepository,
    ) {}

    public function index()
    {
        return $this->medicineRepository->findAll();
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'medicine_category_id' => 'required|string|exists:medicine_categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'expired_date' => 'required|date',
            'unit' => 'required|string',
            'stock' => 'required',
            'price' => 'required',
        ]);

        return $this->medicineRepository->create($validatedData);
    }

    public function show($id)
    {
        return $this->medicineRepository->findById($id);
    }

    public function update($id, Request $request)
    {
        $validatedData = $request->validate([
            'medicine_category_id' => 'required|string|exists:medicine_categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'expired_date' => 'required|date',
            'unit' => 'required|string',
            'stock' => 'required',
            'price' => 'required',
        ]);
        return $this->medicineRepository->update($id, $validatedData);
    }

    public function destroy($id)
    {
        $this->medicineRepository->delete($id);
    }
}
