<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Collection;

class CollectionFactory extends Factory
{
    protected $model = Collection::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word(),
            'ar_name' => $this->faker->unique()->word(),
            'description' => $this->faker->sentence(),
            'ar_description' => $ar_description,
        ];
    }
}
