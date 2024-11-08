<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class UserPhoneFactory extends Factory
{

    public function definition(): array
    {
        return [
            'phone' => $this->faker->unique()->phoneNumber,
            'user_id' => User::inRandomOrder()->first()->id,
        ];
    }
}
