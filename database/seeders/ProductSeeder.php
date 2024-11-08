<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductTranslation;
use App\Models\ProductDimension;
use App\Models\ProductColor;
use App\Models\ProductReview;
use App\Models\ProductFaq;
use App\Models\ProductFaqTranslation;
use App\Models\Platform;
use App\Models\Technology;

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
                $product->dimensions()->save(ProductDimension::factory()->make([
                    'product_id' => $product->id,
                ]));

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
                ])->each(function ($faq) {
                    $faq->save(); // Save FAQ first to get its ID

                    // Seed a single translation for each FAQ
                    $faq->translations()->save(ProductFaqTranslation::factory()->make([
                        'faq_id' => $faq->id,
                        'locale' => 'en',
                    ]));
                }));

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
