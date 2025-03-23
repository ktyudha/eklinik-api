<?php

namespace Database\Seeders;

use App\Models\Medicine\MedicineCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MedicineCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $medicineCategories = ['Antibiotik', 'Anelgesik', 'Antipiretik', 'Antiseptik'];

        for ($i = 0; $i < count($medicineCategories); $i++) {
            MedicineCategory::create([
                'id' => Str::uuid(),
                'name' => $medicineCategories[$i],
                'description' => $medicineCategories[$i],
            ]);
        }
    }
}
