<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\School>
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
            'city_uuid' => \App\Models\City::where('name', 'São Paulo')->first()->uuid,
        ];
    }
}
