<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Platform;

class ProductPlatformFactory extends Factory
{

    public function definition(): array
    {
        return [
            'platform_id' => Platform::inRandomOrder()->first()->id,
        ];
    }
}
