<?php

namespace Database\Seeders;

use App\Models\Classification;
use App\Models\Medical;
use App\Models\Patient;
use App\Models\Menu\SubMenu;
use Carbon\Carbon;
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

        $subMenus = SubMenu::inRandomOrder()->limit(3)->get()->map(function ($subMenu) {
            return [
                'id' => $subMenu->id,
                'name' => $subMenu->name,
                'value' => rand(10, 100), // Bisa diganti dengan nilai lain sesuai kebutuhan
            ];
        });

        Medical::create([
            'id' => Str::uuid(),
            'patient_id' => $randomPatientId,
            'classification_id' => $randomClassificationId,
            'checkup_date' => Carbon::now(),
            'submenu' => $subMenus->toJson(),
        ]);
    }
}
