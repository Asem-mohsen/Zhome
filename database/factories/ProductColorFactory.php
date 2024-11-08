<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductColorFactory extends Factory
{

    public function definition(): array
    {
        return [
            'color' => $this->faker->hexColor,
        ];
    }
}
