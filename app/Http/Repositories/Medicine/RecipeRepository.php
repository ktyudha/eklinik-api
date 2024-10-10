<?php

namespace App\Http\Repositories\Medicine;

use App\Http\Repositories\BaseRepository;
use App\Models\Medicine\Recipe;

class RecipeRepository extends BaseRepository
{
    protected $medicineRepository;
    public function __construct(protected Recipe $recipe, MedicineRepository $medicineRepository)
    {
        parent::__construct($recipe);
        $this->medicineRepository = $medicineRepository;
    }

    public function createRecipeWithMedicine($data)
    {

        $data['amount'] = $this->calculateAmount($data['medicine']);
        $recipe = $this->model::create($data);

        if (isset($data['medicine'])) {
            $recipe->syncMedicines($data['medicine']);
        }

        return $recipe;
    }

    public function updateRecipeWithMedicine($id, $data)
    {

        $recipe = $this->model::findOrFail($id);
        $recipe->update($data);

        if (isset($data['medicine'])) {
            $recipe->syncMedicines($data['medicine']);
        }

        return $recipe;
    }

    private function calculateAmount(array $medicineIds)
    {
        $medicines = $this->medicineRepository->getMedicinesByIds($medicineIds);

        $totalAmount = 0;

        foreach ($medicines as $medicine) {
            $count = array_count_values($medicineIds)[$medicine->id];
            $totalAmount += (int) $medicine->price * $count;
        }

        return $totalAmount;
    }
}
