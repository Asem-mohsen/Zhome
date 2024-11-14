<?php

namespace Database\Seeders;

use App\Models\Collection;
use App\Models\Feature;
use Illuminate\Database\Seeder;

class CollectionFeatureSeeder extends Seeder
{
    public function run(): void
    {
        Collection::all()->each(function ($collection) {
            $features = Feature::inRandomOrder()->take(3)->get();
            $features->each(function ($feature) use ($collection) {
                $collection->features()->attach($feature->id);
            });
        });
    }
}
