<?php

namespace Database\Seeders;

use App\Models\Classification;
use App\Models\Medical;
use App\Models\Patient;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MedicalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Medical::truncate();
        Schema::enableForeignKeyConstraints();

        // Mengambil ID acak dari tabel `patients`
        $randomPatientId = Patient::inRandomOrder()->first()->id;
        $randomClassificationId = Classification::inRandomOrder()->first()->id;
        Medical::create([
            'id' => Str::uuid(),
            'patient_id' => $randomPatientId,
            'classification_id' => $randomClassificationId,
            'diagnosis' => 'sakit',
        ]);
    }
}
