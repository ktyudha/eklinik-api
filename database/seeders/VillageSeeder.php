<?php

namespace Database\Seeders;

use App\Models\Region\Village;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class VillageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Village::truncate();
        Schema::enableForeignKeyConstraints();

        $csvPath = database_path('seed_files/villages.csv');
        $rowHeaders = ['id', 'sub_district_id', 'name', 'postal_code', 'created_at', 'updated_at'];
        $data = csvToArray($rowHeaders, $csvPath);

        $collection = collect($data)->map(function ($data) {
            return [
                'id' => $data['id'],
                'sub_district_id' => $data['sub_district_id'],
                'name' => trim($data['name']),
                'postal_code' => trim($data['postal_code']),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        });

        foreach ($collection->chunk(500) as $chunk) {
            Village::insert($chunk->toArray());
        }
    }
}
