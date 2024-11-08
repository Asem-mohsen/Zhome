<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;
use App\Models\Collection;

class ProductCollectionFactory extends Factory
{
    public function definition()
    {
        return [
            'product_id' => Product::inRandomOrder()->first()->id,
            'collection_id' => Collection::inRandomOrder()->first()->id,
        ];
    }
}
