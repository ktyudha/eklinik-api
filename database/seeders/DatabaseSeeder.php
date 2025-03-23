<?php

namespace Database\Seeders;

use App\Models\Medicine\MedicineCategory;
use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\PatientSeeder;
use Database\Seeders\ClassificationSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RegionSeeder::class);

        $this->call(UserSeeder::class);
        $this->call(PatientSeeder::class);

        $this->call(MenuSeeder::class);
        $this->call(ClassificationSeeder::class);
        $this->call(MedicalSeeder::class);


        $this->call(MedicineCategorySeeder::class);
        $this->call(MedicineSeeder::class);
        $this->call(RecipeSeeder::class);
    }
}
