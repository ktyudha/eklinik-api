<?php

namespace Database\Seeders;

use App\Models\Medical;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MedicalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Medical::truncate();

        Medical::create([
            'id' => Str::uuid(),
            'patient_id' => '81cb826f-e6da-4f9d-b900-2c2a77d0c295',
            'classification_id' => 'c8492ae6-d60a-4933-8b40-5d56910ed511',
            'diagnosis' => 'sakit',
        ]);
    }
}
