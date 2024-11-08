<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

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
