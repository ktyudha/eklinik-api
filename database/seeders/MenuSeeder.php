<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $menus = ['Physical Inspection', 'Diagnosa & Anamnesa'];
        for ($i = 0; $i < count($menus); $i++) {
            Menu::create([
                'id' => Str::uuid(),
                'name' => $menus[$i],
                'is_active' => 1,
            ]);
        }
    }
}
