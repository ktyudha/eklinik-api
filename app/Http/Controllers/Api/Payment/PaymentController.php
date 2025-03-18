<?php

namespace App\Http\Controllers\Api\Payment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pagination\PaginationRequest;
use App\Http\Requests\Payment\PaymentCreateRequest;
use App\Http\Requests\Payment\PaymentUpdateRequest;
use App\Http\Services\Payment\PaymentService;
use App\Http\Resources\Payment\PaymentResource;

class PaymentController extends Controller
{
    public function __construct(protected PaymentService $paymentService) {}

    public function index(PaginationRequest $request): array
    {
        return $this->paymentService->index($request);
    }

    public function store(PaymentCreateRequest $request)
    {
        return response()->json([
            'message' => 'success',
            'payment' => new PaymentResource($this->paymentService->store($request))
        ]);
    }

    public function show($id)
    {
        return response()->json([
            'payment' => new PaymentResource($this->paymentService->show($id))
        ]);
    }

    public function update(PaymentUpdateRequest $request, $id)
    {
        return response()->json([
            'message' => 'success',
            'payment' => new PaymentResource($this->paymentService->update($id, $request))
        ]);
    }

    public function destroy($id)
    {
        $this->paymentService->destroy($id);

        return response()->json([
            'message' => 'success'
        ]);
    }

    public function checkPaymentStatus($snapId)
    {
        return $this->paymentService->checkPaymentStatus($snapId);
    }
}
