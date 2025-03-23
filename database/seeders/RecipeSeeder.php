<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Medicine\Medicine;
use App\Models\Medicine\Recipe;
use App\Models\Medical;
use Illuminate\Support\Str;

class RecipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $medical = Medical::inRandomOrder()->first();
        // Ambil 3 obat secara acak
        $medicines = Medicine::inRandomOrder()->limit(3)->get();

        // Buat resep tanpa langsung menyertakan medicines
        $recipe = Recipe::create([
            'id' => Str::uuid(),
            'patient_id' => $medical->patient_id,
            'medical_id' => $medical->id,
            'description' => 'obat sakit',
            'status' => 'completed',
        ]);

        // Sinkronisasi obat dengan jumlah (quantity) ke tabel pivot
        $medicineData = [];
        foreach ($medicines as $medicine) {
            $medicineData[$medicine->id] = ['quantity' => rand(1, 5)];
        }

        // Masukkan ke tabel pivot recipe_medicine
        $recipe->medicines()->sync($medicineData);
    }
}
