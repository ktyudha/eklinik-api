<?php

namespace Database\Seeders;

use App\Models\Menu\Menu;
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
        $categories = ['KB', 'ANC', 'Anak 1', 'Anak 2'];

        for ($i = 0; $i < count($categories); $i++) {
            Classification::create([
                'id' => Str::uuid(),
                'name' => $categories[$i],
                'description' => $categories[$i],
                'price' => '10000',
            ]);
        }

        $menuIds = Menu::pluck('id')->toArray();
        $classifications = Classification::all();

        foreach ($classifications as $classification) {
            $classification->menus()->sync($menuIds);
        }
    }
}
