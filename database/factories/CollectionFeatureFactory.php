<?php

namespace Database\Factories;

use App\Models\Collection;
use App\Models\Feature;
use Illuminate\Database\Eloquent\Factories\Factory;

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
