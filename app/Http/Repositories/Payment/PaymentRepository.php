<?php

namespace App\Http\Repositories\Payment;

use App\Http\Repositories\BaseRepository;
use App\Models\Payment;
use Midtrans\Config;
use Midtrans\Snap;

class PaymentRepository extends BaseRepository
{
    public function __construct(protected Payment $payment)
    {
        parent::__construct($payment);

        // Config::$serverKey = config('services.midtrans.serverKey');
        // Config::$isProduction = config('services.midtrans.isProduction');
        // Config::$isSanitized = config('services.midtrans.isSanitized');
        // Config::$is3ds = config('services.midtrans.is3ds');
    }

    public function createPayment($data)
    {
        $payment = $this->model::create($data);

        $payload = [
            'transaction_details' => [
                'order_id' => uniqid(),
                'gross_amount'  => 50000,
            ],
            'customer_details' => [
                'first_name'    => 'Yudha',
                'email'         => 'ktyoedha@gmail.com',
                // 'phone'         => '08888888888',
                // 'address'       => '',
            ],
        ];

        $snapToken = Snap::getSnapToken($payload);
        $payment->snap_token = $snapToken;
        $payment->save();
        return $payment;
    }

    // public function createRecipeWithMedicine($data)
    // {

    //     $data['amount'] = $this->calculateAmount($data['medicine']);
    //     $recipe = $this->model::create($data);

    //     if (isset($data['medicine'])) {
    //         $recipe->syncMedicines($data['medicine']);
    //     }

    //     return $recipe;
    // }

    // public function updateRecipeWithMedicine($id, $data)
    // {

    //     $recipe = $this->model::findOrFail($id);
    //     $recipe->update($data);

    //     if (isset($data['medicine'])) {
    //         $recipe->syncMedicines($data['medicine']);
    //     }

    //     return $recipe;
    // }

    // private function calculateAmount(array $medicineIds)
    // {
    //     $medicines = $this->medicineRepository->getMedicinesByIds($medicineIds);

    //     $totalAmount = 0;

    //     foreach ($medicines as $medicine) {
    //         $count = array_count_values($medicineIds)[$medicine->id];
    //         $totalAmount += (int) $medicine->price * $count;
    //     }

    //     return $totalAmount;
    // }
}
