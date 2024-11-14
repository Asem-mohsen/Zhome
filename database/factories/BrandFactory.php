<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BrandFactory extends Factory
{
    public function definition(): array
    {
        $brands = [
            'Apple', 'Google', 'DoorBird', 'POPP', 'Honor', 'Somfy', 'Eufy',
            'Aeotec', 'Fibaro', 'Heati', 'Ezviz', 'Nebula', 'Philio', 'Yale', 'Tp-Link',
        ];

        return [
            'name' => $this->faker->unique()->randomElement($brands),
            'description' => $this->faker->sentence(),
            'ar_description' => $this->faker->sentence(),
        ];
    }
}
