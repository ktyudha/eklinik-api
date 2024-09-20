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
            'name' => 'Pasien 1',
            'no_medical_record' => '2409000001',
            'address' => 'Surabaya',
        ]);
        // }
    }
}
