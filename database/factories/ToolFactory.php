<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ToolFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word,
            'description' => $this->faker->paragraph,
            'ar_name' => $this->faker->unique()->word,
            'ar_description' => $this->faker->paragraph,
        ];
    }
}
