<?php

namespace Database\Seeders;

use App\Models\Region\SubDistrict;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SubDistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        SubDistrict::truncate();
        Schema::enableForeignKeyConstraints();

        $csvPath = database_path('seed_files/districts.csv');
        $rowHeaders = ['id', 'city_id', 'name', 'created_at', 'updated_at'];
        $data = csvToArray($rowHeaders, $csvPath);

        $collection = collect($data)->map(function ($data) {
            return [
                'id' => $data['id'],
                'city_id' => $data['city_id'],
                'name' => trim($data['name']),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        });

        foreach ($collection->chunk(500) as $chunk) {
            SubDistrict::insert($chunk->toArray());
        }
    }
}
