<?php

namespace Database\Seeders;

use App\Models\Region\Province;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Province::truncate();
        Schema::enableForeignKeyConstraints();

        $csvPath = database_path('seed_files/provinces.csv');
        $rowHeaders = ['id', 'name', 'created_at', 'updated_at'];
        $data = csvToArray($rowHeaders, $csvPath);

        $collection = collect($data)->map(function ($data) {
            return [
                'id' => $data['id'],
                'name' => trim($data['name']),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        });

        foreach ($collection->chunk(100) as $chunk) {
            Province::insert($chunk->toArray());
        }
    }
}
