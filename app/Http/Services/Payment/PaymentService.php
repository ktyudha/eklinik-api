<?php

namespace App\Http\Services\Payment;

use App\Http\Repositories\Medical\MedicalRepository;
use App\Http\Repositories\Medicine\RecipeRepository;
use App\Models\Payment;
use App\Http\Requests\Payment\PaymentCreateRequest;
use App\Http\Requests\Payment\PaymentUpdateRequest;
use App\Http\Resources\Payment\PaymentResource;
use App\Http\Requests\Pagination\PaginationRequest;
use App\Http\Repositories\Payment\PaymentRepository;
use App\Http\Resources\Medical\MedicalResource;
use Carbon\Carbon;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction;
use GuzzleHttp\Client;
use Midtrans\CoreApi;

class PaymentService
{
    public function __construct(
        protected PaymentRepository $paymentRepository,
        protected MedicalRepository $medicalRepository,
        protected RecipeRepository $recipeRepository
    ) {
        Config::$serverKey = config('midtrans.serverKey');
        Config::$isProduction = config('midtrans.isProduction');
        Config::$isSanitized = config('midtrans.isSanitized');
        Config::$is3ds = config('midtrans.is3ds');
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
        $validated = $request->validated();

        try {
            $medical = $this->medicalRepository->findById($validated['medical_id'], ['recipe', 'classification']);
            $itemDetails = collect([]);
            $customer = [];
            $orderId = generateInvoiceNumber();
            $acquirer = "gopay";

            if ($medical->classification) {
                $itemDetails->push([
                    'id'        => 'medical-' . $medical->classification->id,
                    'price'     => (int) $medical->classification->price,
                    'quantity'  => 1,
                    'name'      => $medical->classification->name,
                    'category'  => 'Medical',
                ]);
            }

            if ($medical->recipe && $medical->recipe->medicines->isNotEmpty()) {
                $medicines = $medical->recipe->medicines->map(function ($medicine) {
                    return [
                        'id'       => 'medicine-' . $medicine->id,
                        'price'    => (int) $medicine->price,
                        'quantity' => (float) $medicine->pivot->quantity,
                        'name'     => $medicine->name,
                        'category' => 'Medicine',
                    ];
                });

                $itemDetails = $itemDetails->merge($medicines);
            }

            $gross = $itemDetails->sum(fn($item) => $item['price'] * $item['quantity']);

            if ($medical->patient) {
                $patient = $medical->patient;
                $customer = [
                    'name' => $patient->name,
                    'email' => $patient->email,
                    'phone' => $patient->phone_number,
                    'billing_address' => [
                        'name' => $patient->name,
                        'email' => $patient->email,
                        'phone' => $patient->phone_number,
                        'address' => $patient->village->name,
                        'city' => $patient->city->name,
                        'postal_code' => $patient->village->postal_code,
                        'country_city' => 'IDN',
                    ],
                ];
            }

            $payload = [
                'transaction_details' => [
                    'order_id'      => $orderId,
                    'gross_amount'  => $gross,
                ],
                'payment_type' => $validated['payment_type'],
                'qris' => [
                    'acquirer' => $acquirer,
                ],
                // 'payment_type' => 'gopay',
                // 'bank_transfer' => [
                //     'bank' => 'bca'
                // ],
                'item_details' => $itemDetails,
                'customer_details' => $customer
            ];

            $body = CoreApi::charge($payload);
            // $response = Snap::createTransaction($payload);

            if (!isset($body->order_id) || !isset($body->actions[0]->url)) {
                throw new \Exception('Invalid Midtrans response');
            }

            $validated['order_id'] = $body->order_id;
            $validated['gross_amount'] = $body->gross_amount;
            $validated['qris_url'] = $body->actions[0]->url;
            $validated['qris_raw'] = $body->qr_string ?? null;
            $validated['acquirer'] = $body->acquirer ?? null;
            $validated['transaction_time'] = $body->transaction_time ?? null;
            $validated['transaction_status'] = $body->transaction_status ?? 'pending';
            $validated['transaction_expired_time'] = $body->expiry_time ?? null;

            $payment =  $this->paymentRepository->create($validated);
            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Successfully',
                    'data' => $payment,
                ]
            );
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
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

    public function checkPaymentStatus($snapId)
    {
        $status = Transaction::status($snapId);
        return response()->json([
            'data' => $status
        ]);
    }
}
