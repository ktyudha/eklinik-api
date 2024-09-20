<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Group\Group;
use App\Models\Region\City;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        City::truncate();
        Schema::enableForeignKeyConstraints();

        $csvPath = database_path('seed_files/cities.csv');
        $rowHeaders = ['id', 'province_id', 'name', 'created_at', 'updated_at'];
        $data = csvToArray($rowHeaders, $csvPath);

        $collection = collect($data)->map(function ($data) {
            return [
                'id' => $data['id'],
                'province_id' => $data['province_id'],
                'name' => trim($data['name']),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        });

        foreach ($collection->chunk(100) as $chunk) {
            City::insert($chunk->toArray());
        }
    }
}
