<?php

namespace Database\Seeders;

use App\Models\Menu\SubMenu;
use App\Models\Menu\Menu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SubMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subMenus = ['Diagnosa', 'Sistole', 'Diastole', 'Suhu'];

        for ($i = 0; $i < count($subMenus); $i++) {
            SubMenu::create([
                'id' => Str::uuid(),
                'name' => $subMenus[$i],
                'type' => "input",
                'is_active' => 1,
                'menu_id' => Menu::inRandomOrder()->first()->id
            ]);
        }
    }
}
