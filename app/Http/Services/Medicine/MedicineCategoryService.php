<?php

namespace App\Http\Services\Medicine;

use App\Http\Repositories\Medicine\MedicineCategoryRepository;
use Illuminate\Http\Request;

class MedicineCategoryService
{
    public function __construct(
        protected MedicineCategoryRepository $medicineCategoryRepository,
    ) {}

    public function index()
    {
        return $this->medicineCategoryRepository->findAll();
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        return $this->medicineCategoryRepository->create($validatedData);
    }

    public function show($id)
    {
        return $this->medicineCategoryRepository->findById($id);
    }

    public function update($id, Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        return $this->medicineCategoryRepository->update($id, $validatedData);
    }

    public function destroy($id)
    {
        $this->medicineCategoryRepository->delete($id);
    }
}
