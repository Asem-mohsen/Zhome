<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Collection;
use App\Models\Feature;

class CollectionFeatureFactory extends Factory
{
    public function definition()
    {
        return [
            'collection_id' => Collection::inRandomOrder()->first()->id,
            'feature_id' => Feature::inRandomOrder()->first()->id,
        ];
    }
}
