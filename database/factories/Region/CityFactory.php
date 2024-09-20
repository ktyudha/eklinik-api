<?php

namespace Database\Factories\Region;

use App\Models\Region\Province;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Region\City>
 */
class CityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $randomProvinceId = Province::inRandomOrder()->first()->id;

        return [
            'province_id' => $randomProvinceId,
            'name' => $this->faker->unique()->city,
        ];
    }
}
