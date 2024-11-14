<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

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
