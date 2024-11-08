<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductTranslationFactory extends Factory
{

    public function definition(): array
    {
        return [
            'locale' => 'en',
            'name' => $this->faker->word,
            'description' => $this->faker->paragraph,
            'additional_description' => $this->faker->sentence,
            'title' => $this->faker->sentence,
            'second_title' => $this->faker->sentence,
        ];
    }
}
