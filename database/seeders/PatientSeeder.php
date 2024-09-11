<?php

namespace Database\Seeders;

use App\Models\Patient;
use Illuminate\Database\Seeder;


class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // for ($i = 0; $i <= 2; $i++) {
        Patient::create([
            'name' => fake()->name,
            'no_medical_record' => '200029011',
            'address' => 'Surabaya',
        ]);
        // }
    }
}
