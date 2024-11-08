<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    
    public function definition(): array
    {

        return [
            'name' => $this->faker->word,
            'description' => $this->faker->paragraph,
            'additional_description' => $this->faker->sentence,
            'ar_name' => $this->faker->word,
            'ar_description' => $this->faker->paragraph,
            'ar_additional_description' => $this->faker->sentence,
            'has_sub' => $this->faker->boolean,
        ];
    }
}
