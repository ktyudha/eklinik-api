<?php

namespace Database\Factories\Region;

use App\Models\Region\City;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Region\SubDistrict>
 */
class SubDistrictFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $randomCityId = City::inRandomOrder()->first()->id;

        return [
            'city_id' => $randomCityId,
            'name' => $this->faker->unique()->streetName . ' Sub District',
        ];
    }
}
