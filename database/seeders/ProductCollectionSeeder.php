<?php

namespace Database\Seeders;

use App\Models\Collection;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductCollectionSeeder extends Seeder
{
    public function run()
    {
        Collection::all()->each(function ($collection) {
            $products = Product::inRandomOrder()->take(10)->pluck('id');
            foreach ($products as $productId) {
                DB::table('product_collections')->insert([
                    'product_id' => $productId,
                    'collection_id' => $collection->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        });
    }
}
