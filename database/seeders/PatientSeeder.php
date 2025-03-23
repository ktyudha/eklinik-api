<?php

namespace Database\Seeders;

use App\Models\Patient;
use Illuminate\Database\Seeder;


class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Patient::create([
            'name' => 'Barjon Becak Kopling',
            'username' => 'barjon',
            'birth_place' => 'Mojokerto',
            'birth_date' => '2024-01-01',
            'password' => 'password',
            'encrypted_password' => bcrypt('password'),
            'nik' => '35105010121',
            'email' => 'barjon@gmail.com',
            'phone_number' => '085848250547',
            'religion' => 'Islam',
            'gender' => 'Laki-laki',
            'marital_status' => 'single',
            'education' => 'SMA/SMK/MA/MAK',
            'job' => 'Belum/Tidak Bekejra',
            'province_id' => '35',
            'city_id' => '3515',
            'sub_district_id' => '351503',
            'village_id' => '3515032013',
        ]);
    }
}
