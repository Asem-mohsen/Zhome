<?php

namespace App\Traits;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Platform;

trait NavigationTrait
{
    protected function getNavigationData()
    {

        $categories = Category::whereHas('subcategories.products')
            ->with(['subcategories' => function ($query) {
                $query->whereHas('products');
            }])->get();
        $brands = Brand::with('media')->get();
        $platforms = Platform::with('media')->get();

        return compact('categories', 'brands', 'platforms');
    }
}
