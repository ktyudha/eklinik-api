<?php

namespace App\Http\Services\Classification;

use App\Http\Repositories\Classification\ClassificationRepository;

class ClassificationService
{
    public function __construct(
        protected ClassificationRepository $classificationRepository,
    ) {}

    public function index()
    {
        return $this->classificationRepository->findAll();
    }
}
