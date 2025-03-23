<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Medicine\Medicine;
use App\Models\Medicine\MedicineCategory;
use Carbon\Carbon;
use Illuminate\Support\Str;

class MedicineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $medicineCategories = [
            [
                'name' => 'Paracetamol',
                'unit' => 'satuan',
                'stock' => '10',
                'price' => '10000',
            ],
            [
                'name' => 'Bodrex',
                'unit' => 'satuan',
                'stock' => '20',
                'price' => '13000',
            ],
            [
                'name' => 'Amoxilin',
                'unit' => 'satuan',
                'stock' => '5',
                'price' => '25000',
            ],
            [
                'name' => 'OBH Combi',
                'unit' => 'satuan',
                'stock' => '50',
                'price' => '5000',
            ],
        ];

        for ($i = 0; $i < count($medicineCategories); $i++) {
            Medicine::create([
                'id' => Str::uuid(),
                'name' => $medicineCategories[$i]['name'],
                'description' => $medicineCategories[$i]['name'],
                'medicine_category_id' => MedicineCategory::inRandomOrder()->first()->id,
                'expired_date' => Carbon::now()->addMonth(),
                'unit' => $medicineCategories[$i]['unit'],
                'stock' => $medicineCategories[$i]['stock'],
                'price' => $medicineCategories[$i]['price'],
            ]);
        }
    }
}
