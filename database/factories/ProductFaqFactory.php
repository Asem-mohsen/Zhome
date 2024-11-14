<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFaqFactory extends Factory
{
    public function definition(): array
    {
        return [
            'product_id' => Product::inRandomOrder()->first()->id,
            'question' => $this->faker->sentence,
            'answer' => $this->faker->paragraph,
            'ar_question' => $this->faker->sentence,
            'ar_answer' => $this->faker->paragraph,
        ];
    }
}
