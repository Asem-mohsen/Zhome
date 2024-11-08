<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Technology;

class ProductTechnologyFactory extends Factory
{

    public function definition(): array
    {
        return [
            'technology_id' => Technology::inRandomOrder()->first()->id,
        ];
    }
}
