<?php

namespace Database\Factories\School;

use App\Models\Location\City;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\School\School>
 */
class SchoolFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company,
            'email' => $this->faker->companyEmail,
            'zip_code' => $this->faker->postcode,
            'district' => $this->faker->city,
            'email_responsible' => $this->faker->companyEmail,
            'city_uuid' => City::where('ibge_code', '1100015')->first()->uuid,
        ];
    }
}
