<?php

namespace Database\Factories;

use App\Models\Platform;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlatformFAQFactory extends Factory
{
    public function definition(): array
    {
        return [
            'platform_id' => Platform::inRandomOrder()->first()->id,
            'question' => $this->faker->sentence(),
            'answer' => $this->faker->paragraph(),
        ];
    }
}
