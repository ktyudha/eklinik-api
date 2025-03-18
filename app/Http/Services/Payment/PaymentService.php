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
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction;

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
        // return $this->paymentRepository->create($request->validated());
        // $payment = $this->paymentRepository->create($request->validated());

        $medical = $this->medicalRepository->findById($validated['medical_id'], ['recipe', 'classification']);

        $itemDetails = collect([]);

        // Tambahkan data classification jika ada
        if ($medical->classification) {
            $itemDetails->push([
                'id'        => 'medical-' . $medical->classification->id,
                'price'     => (int) $medical->classification->price,
                'quantity'  => 1,
                'name'      => $medical->classification->name,
                'category'  => 'Medical',
            ]);
        }

        // Tambahkan data recipe jika ada
        // if ($medical->recipe) {
        //     $itemDetails[] = [
        //         'id'        => 'recipe-' . $medical->recipe->id,
        //         'price'     => $medical->recipe->amount,
        //         'quantity'  => 1,
        //         'name'      => 'Medical Recipe',
        //         'category'  => 'Prescription',
        //     ];
        // }

        if ($medical->recipe && $medical->recipe->medicines->isNotEmpty()) {
            $medicines = $medical->recipe->medicines->map(function ($medicine) {
                return [
                    'id'       => 'medicine-' . $medicine->id,
                    'price'    => (int) $medicine->price,
                    'quantity' => 1, // Sesuaikan jumlah jika ada informasi kuantitas
                    'name'     => $medicine->name,
                    'category' => 'Medicine',
                ];
            });

            $itemDetails = $itemDetails->merge($medicines);
        }

        // Hitung total harga
        // $gross = collect($itemDetails)->sum('price');
        $gross = $itemDetails->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });


        $payload = [
            'transaction_details' => [
                'order_id'      => uniqid(),
                'gross_amount'  => $gross,
            ],
            'item_details' => $itemDetails,
            // 'customer_details' => [
            //     'first_name' => 'Kurniawan Try',
            //     'last_name' => 'Yudha',
            //     'email' => 'ktyoedha@gmail.com',
            //     'phone' => '+6285848250548',
            //     'billing_address' => [
            //         'first_name' => 'Steven',
            //         'last_name' => 'Jowo',
            //         'email' => 'stefen.jowo@gmail.com',
            //         'phone' => '+6285848250548',
            //         'address' => 'Mojokerto',
            //         'city' => 'Mojokerto',
            //         'postal_code' => '12190',
            //         'country_city' => 'IDN',
            //     ]
            // ]
        ];
        return response()->json([
            'payload' => $payload,
            'medical' => $medical->recipe->medicines
        ]);
        // $snapToken = Snap::getSnapToken($payload);
        // $data = [
        //     'snap_token' => $snapToken,
        //     // 'redirect_url' => `https://app.sandbox.midtrans.com/snap/v2/vtweb/` . $snapToken
        // ];


        // $payload = [
        //     'transaction_details' => [
        //         'order_id'      => uniqid(),
        //         'gross_amount'  => '2000',
        //     ],
        //     'item_details' => [
        //         [
        //             'id' => 1,
        //             'price' => '150000',
        //             'quantity' => 1,
        //             'name' => 'Flashdisk Toshiba 32GB',
        //             'brand' => 'SanDisk',
        //             'category' => 'Electronics',
        //             'merchant_name' => 'Agung Computer',
        //             'url' => 'https://tokobuah.com/apple-fuji',
        //         ],
        //         // [
        //         //     'id' => 2,
        //         //     'price' => '60000',
        //         //     'quantity' => 2,
        //         //     'name' => 'Memory Card VGEN 4GB',
        //         // ],
        //     ],
        //     'customer_details' => [
        //         'first_name' => 'Kurniawan Try',
        //         'last_name' => 'Yudha',
        //         'email' => 'ktyoedha@gmail.com',
        //         'phone' => '+6285848250548',
        //         'billing_address' => [
        //             'first_name' => 'Steven',
        //             'last_name' => 'Jowo',
        //             'email' => 'stefen.jowo@gmail.com',
        //             'phone' => '+6285848250548',
        //             'address' => 'Mojokerto',
        //             'city' => 'Mojokerto',
        //             'postal_code' => '12190',
        //             'country_city' => 'IDN',
        //         ]
        //     ]
        // ];
        // $snapToken = Snap::getSnapToken($payload);
        // $data = [
        //     'snap_token' => $snapToken,
        //     // 'redirect_url' => `https://app.sandbox.midtrans.com/snap/v2/vtweb/` . $snapToken
        // ];

        // $this->paymentRepository->update($payment->id, $data);

        // return $payment;
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
