<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use App\Models\Classification;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ClassificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Classification::truncate();
        Schema::enableForeignKeyConstraints();

        Classification::create([
            'id' => Str::uuid(),
            'name' => fake()->name,
            'description' => 'halo',
            'price' => '10000',
        ]);
    }
}
