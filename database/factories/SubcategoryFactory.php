<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubcategoryFactory extends Factory
{
    protected $model = Subcategory::class;

    public function definition(): array
    {
        return [
            'category_id' => Category::inRandomOrder()->first()->id,
            'name' => $this->faker->unique()->word(),
            'description' => $this->faker->sentence(),
            'ar_name' => $this->faker->unique()->word(),
            'ar_description' => $this->faker->sentence(),
            'status' => 'active',
        ];
    }
}
