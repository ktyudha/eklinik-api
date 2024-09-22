<?php

namespace App\Http\Repositories\Payment;

use App\Http\Repositories\BaseRepository;
use App\Models\Payment;

class PaymentRepository extends BaseRepository
{
    public function __construct(protected Payment $payment)
    {
        parent::__construct($payment);
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
