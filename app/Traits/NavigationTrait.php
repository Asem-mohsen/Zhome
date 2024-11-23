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
                $query->whereHas('products')->select('name' , 'ar_name' , 'id');
            }])->get();
        $brands = Brand::select('name','id')->with('media')->get();
        $platforms = Platform::select('name','id')->with('media')->get();

        return compact('categories', 'brands', 'platforms');
    }
}
