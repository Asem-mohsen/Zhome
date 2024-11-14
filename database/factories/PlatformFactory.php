<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PlatformFactory extends Factory
{
    public function definition(): array
    {

        return [
            'name' => $this->faker->word,
            'video_url' => $this->faker->url(),
            'description' => $this->faker->sentence(),
            'ar_description' => $this->faker->sentence(),
        ];

    }
}
