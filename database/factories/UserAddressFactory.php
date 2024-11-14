<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserAddressFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'city' => $this->faker->city,
            'country' => $this->faker->country,
            'street_address' => $this->faker->streetAddress,
            'floor' => $this->faker->randomDigitNotNull,
            'building' => $this->faker->buildingNumber,
            'apartment' => $this->faker->randomDigitNotNull,
        ];
    }
}
