<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use App\Models\Region\Country;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Country::truncate();
        Schema::enableForeignKeyConstraints();

        $csvPath = database_path('seed_files/countries.csv');
        $rowHeaders = ['code', 'name'];
        $data = csvToArray($rowHeaders, $csvPath, ',');

        $collection = collect($data)->map(function ($data) {
            return [
                'id' => Str::uuid()->toString(),
                'code' => trim($data['code']),
                'name' => trim($data['name']),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        });

        foreach ($collection->chunk(100) as $chunk) {
            Country::insert($chunk->toArray());
        }
    }
}
