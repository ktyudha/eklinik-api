<?php

namespace Database\Seeders;

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
        $this->call(UserSeeder::class);
        $this->call(PatientSeeder::class);

        $this->call(MenuSeeder::class);
        $this->call(ClassificationSeeder::class);
        // $this->call(MedicalSeeder::class);
    }
}
