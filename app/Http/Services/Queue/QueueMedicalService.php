<?php

namespace App\Http\Services\Queue;

use App\Http\Requests\Queue\QueueMedicalCreateRequest;
use App\Http\Requests\Queue\QueueMedicalUpdateRequest;
use App\Http\Repositories\Queue\QueueMedicalRepository;

class QueueMedicalService
{
    public function __construct(
        protected QueueMedicalRepository $queueMedicalRepository,
    ) {}

    public function index()
    {
        return $this->queueMedicalRepository->findAll();
    }

    public function store(QueueMedicalCreateRequest $request)
    {
        return $this->queueMedicalRepository->create($request->validated());
    }

    public function show($id)
    {
        return $this->queueMedicalRepository->findById($id);
    }

    public function update($id, QueueMedicalUpdateRequest $request)
    {
        return $this->queueMedicalRepository->update($id, $request->validated());
    }

    public function destroy($id)
    {
        $this->queueMedicalRepository->delete($id);
    }
}
