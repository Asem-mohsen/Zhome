<?php

namespace Database\Factories;

use App\Models\Technology;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductTechnologyFactory extends Factory
{
    public function definition(): array
    {
        return [
            'technology_id' => Technology::inRandomOrder()->first()->id,
        ];
    }
}
