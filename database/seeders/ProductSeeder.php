<?php

namespace Database\Seeders;

use App\Models\{ Platform ,Product , ProductColor , ProductDimension , ProductReview , ProductFaq, ProductTranslation,Technology};
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $platformIds = Platform::pluck('id')->toArray();
        $technologyIds = Technology::pluck('id')->toArray();

        Product::factory()
            ->count(50)
            ->create()
            ->each(function ($product) use ($platformIds, $technologyIds) {
                $product->translations()->save(ProductTranslation::factory()->make([
                    'product_id' => $product->id,
                ]));

                // Seed dimensions for each product
                ProductDimension::factory()->count(3)->create([
                    'product_id' => $product->id,
                ]);

                // Seed colors
                $product->colors()->saveMany(ProductColor::factory()->count(3)->make([
                    'product_id' => $product->id,
                ])->unique('color'));

                // Seed platforms
                $randomPlatformIds = collect($platformIds)->random(2)->all();
                $product->platforms()->attach($randomPlatformIds);

                // Seed FAQs with translations
                $product->faqs()->saveMany(ProductFaq::factory()->count(3)->make([
                    'product_id' => $product->id,
                ]));

                // Seed reviews
                $product->reviews()->saveMany(ProductReview::factory()->count(3)->make([
                    'product_id' => $product->id,
                ]));

                // Seed technologies
                $randomTechnologyIds = collect($technologyIds)->random(rand(3, 4))->all();
                $product->technologies()->attach($randomTechnologyIds);
            });

    }
}
