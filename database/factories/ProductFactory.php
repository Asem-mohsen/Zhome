<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Subcategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'price' => $this->faker->randomFloat(2, 50, 1000),
            'installation_cost' => $this->faker->randomFloat(2, 20, 200),
            'quantity' => $this->faker->numberBetween(1, 100),
            'is_bundle' => $this->faker->boolean,
            'brand_id' => Brand::inRandomOrder()->first()->id,
            'subcategory_id' => Subcategory::inRandomOrder()->first()->id,
            'added_by' => User::inRandomOrder()->first()->id,
            'updated_by' => User::inRandomOrder()->first()->id,
            'video_url' => $this->faker->url,
        ];
    }
}
