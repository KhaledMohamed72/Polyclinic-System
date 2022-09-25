<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Clinic>
 */
class ClinicFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'domain' => $this->faker->word,
            'phone' => $this->faker->phoneNumber,
            'email' => $this->faker->domainName,
            'password' => bcrypt(123123),
        ];
    }
}
