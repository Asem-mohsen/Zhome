<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RoleFactory extends Factory
{

    public function definition(): array
    {
        return [
            'role' => $this->faker->unique()->randomElement(['user', 'master admin', 'developer', 'HR']),
        ];
    }
}
