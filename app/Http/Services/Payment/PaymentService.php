<?php

namespace App\Http\Services\Payment;

use App\Models\Payment;
use App\Http\Requests\Payment\PaymentCreateRequest;
use App\Http\Requests\Payment\PaymentUpdateRequest;
use App\Http\Resources\Payment\PaymentResource;
use App\Http\Requests\Pagination\PaginationRequest;
use App\Http\Repositories\Payment\PaymentRepository;
use Midtrans\Config;
use Midtrans\Snap;

class PaymentService
{
    public function __construct(
        protected PaymentRepository $paymentRepository,
    ) {
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = config('services.midtrans.isSanitized');
        Config::$is3ds = config('services.midtrans.is3ds');
    }

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
        // return $this->paymentRepository->create($request->validated());
        $payment = $this->paymentRepository->create($request->validated());
        $payload = [
            'transaction_details' => [
                'order_id'      => '1',
                'gross_amount'  => '2000',
            ],
            'item_details' => [
                [
                    'id' => 1,
                    'price' => '150000',
                    'quantity' => 1,
                    'name' => 'Flashdisk Toshiba 32GB',
                ],
                [
                    'id' => 2,
                    'price' => '60000',
                    'quantity' => 2,
                    'name' => 'Memory Card VGEN 4GB',
                ],
            ],
            'customer_details' => [
                'first_name' => 'Martin Mulyo Syahidin',
                'email' => 'mulyosyahidin95@gmail.com',
                'phone' => '081234567890',
            ]
        ];
        $snapToken = Snap::getSnapToken($payload);
        $data = [
            'snap_token' => $snapToken,
        ];

        $this->paymentRepository->update($payment->id, $data);

        return $payment;
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
