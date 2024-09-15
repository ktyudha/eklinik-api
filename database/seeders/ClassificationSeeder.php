<?php

namespace Database\Seeders;

use App\Models\Menu;
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

        $categories = ['KB', 'ANC', 'Anak 1', 'Anak 2'];
        $randomMenuId = Menu::inRandomOrder()->first()->id;

        for ($i = 0; $i < count($categories); $i++) {
            Classification::create([
                'id' => Str::uuid(),
                'menu_id' => $randomMenuId,
                'name' => $categories[$i],
                'description' => $categories[$i],
                'price' => '10000',
            ]);
        }
    }
}
