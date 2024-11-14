<?php

namespace Database\Factories;

use App\Models\Collection;
use Illuminate\Database\Eloquent\Factories\Factory;

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
