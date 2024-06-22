<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Category;
use Carbon\Carbon;
use App\Models\Product;
use App\Models\Promocode;
use App\Models\Platform;

class ShopController extends Controller
{
    public function index()
        {
            $currentDate = Carbon::now();

        // Selscted brands
        $brand         = Brand::findOrFail(1);
        $productsBrand = Product::with(['brand', 'platforms', 'subcategory.category'])
                        ->where('BrandID', $brand->ID)
                        ->get();

        // Selected category
        $category           = Category::with('subcategories')->findOrFail(4);
        $category2          = Category::with('subcategories')->findOrFail(3);
        $categoriesProduct  = Product::with(['brand', 'platforms', 'subcategory.category'])
                                ->whereHas('subcategory', function ($query) use ($category) {
                                    $query->where('MainCategoryID', $category->ID);
                                })
                                ->get();
        $categoriesProduct2 = Product::with(['brand', 'platforms', 'subcategory.category'])
                                ->whereHas('subcategory', function ($query) use ($category2) {
                                    $query->where('MainCategoryID', $category2->ID);
                                })
                                ->get();
        
        // All
        $brands    = Brand::all();
        $platforms = Platform::all();
        $categories= Category::all();

        // conditions
        $bundles        = Product::with(['brand', 'platforms', 'subcategory.category'])->where('IsBundle' , '1')->limit(3)->get();
        $productsOnSale = Product::with(['sale' , 'brand' , 'subcategory'])
                                ->get();
        $promocodes     = Promocode::where('EndsIn', '>', $currentDate)->where('Status' , '1')->orderBy('EndsIn')->limit(1)->first();
        $bundle         = Product::with(['brand', 'platforms', 'subcategory.category'])->where('IsBundle' , '1')->limit(1)->first();
        return view('User.Shop.shop', compact('brands' , 'platforms','brand' , 'productsBrand' , 'category' , 'bundles' ,'categories' , 'productsOnSale' , 'promocodes','category2','categoriesProduct' , 'categoriesProduct2' , 'bundle'));
    }
}