<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductTranslationFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'ar_name' => $this->faker->word,
            'description' => $this->faker->paragraph,
            'additional_description' => $this->faker->sentence,
            'ar_description' => $this->faker->paragraph,
            'ar_additional_description' => $this->faker->sentence,
            'title' => $this->faker->sentence,
            'second_title' => $this->faker->sentence,
            'ar_title' => $this->faker->sentence,
            'ar_second_title' => $this->faker->sentence,
        ];
    }
}
