<?php

namespace App\Http\Services\Payment;

use App\Models\Payment;
use App\Http\Requests\Payment\PaymentCreateRequest;
use App\Http\Requests\Payment\PaymentUpdateRequest;
use App\Http\Resources\Payment\PaymentResource;
use App\Http\Requests\Pagination\PaginationRequest;
use App\Http\Repositories\Payment\PaymentRepository;

class PaymentService
{
    public function __construct(
        protected PaymentRepository $paymentRepository,
    ) {}

    public function index(PaginationRequest $request): array
    {
        return customPaginate(
            new Payment(),
            [
                'property_name' => 'payments',
                'resource' => PaymentResource::class,
                'sort_by' => 'oldest',
                'sort_by_property' => 'id',
                // 'relations' => ['patient', 'medical'],
            ],
            $request->limit ?? 10
        );
    }

    public function store(PaymentCreateRequest $request)
    {
        return $this->paymentRepository->create($request->validated());
    }

    public function show($id)
    {
        return $this->paymentRepository->findById($id);
    }

    public function update($id, PaymentUpdateRequest $request)
    {
        return $this->paymentRepository->update($id, $request->validated());
    }

    public function destroy($id)
    {
        $this->paymentRepository->delete($id);
    }
}
