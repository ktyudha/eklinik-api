<?php

namespace App\Http\Services\Medical;

use App\Http\Requests\Medical\MedicalCreateRequest;
use App\Http\Requests\Medical\MedicalUpdateRequest;
use App\Http\Repositories\Medical\MedicalRepository;

class MedicalService
{
    public function __construct(
        protected MedicalRepository $medicalRepository,
    ) {}

    public function index()
    {
        return $this->medicalRepository->findAll();
    }

    public function store(MedicalCreateRequest $request)
    {
        return $this->medicalRepository->create($request->validated());
    }

    public function show($id)
    {
        return $this->medicalRepository->findById($id);
    }

    public function update($id, MedicalUpdateRequest $request)
    {
        return $this->medicalRepository->update($id, $request->validated());
    }

    public function destroy($id)
    {
        $this->medicalRepository->delete($id);
    }
}
