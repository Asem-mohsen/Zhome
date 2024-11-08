<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFaqTranslationFactory extends Factory
{

    public function definition(): array
    {
        return [
            'faq_id' => null, 
            'locale' => 'en',
            'question' => $this->faker->sentence,
            'answer' => $this->faker->paragraph,
        ];
    }
}
