<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Classification;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\PatientSeeder;
use Illuminate\Support\Facades\Schema;
use Database\Seeders\ClassificationSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        User::truncate();
        Classification::truncate();
        Schema::enableForeignKeyConstraints();

        $this->call(UserSeeder::class);
        $this->call(PatientSeeder::class);

        $this->call(ClassificationSeeder::class);
        // $this->call(ClassificationSeeder::class);
    }
}
