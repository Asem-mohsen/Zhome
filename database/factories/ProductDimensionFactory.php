<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductDimensionFactory extends Factory
{

    public function definition(): array
    {
        return [
            'width' => $this->faker->randomFloat(2, 1, 100),
            'height' => $this->faker->randomFloat(2, 1, 100),
            'length' => $this->faker->randomFloat(2, 1, 100),
            'capacity' => $this->faker->randomFloat(2, 1, 50),
            'noise_level' => $this->faker->randomFloat(2, 10, 80),
            'weight' => $this->faker->randomFloat(2, 0.1, 50),
            'power_consumption' => $this->faker->randomFloat(2, 5, 200),
        ];
    }
}
