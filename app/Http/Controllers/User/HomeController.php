<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Platform;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Traits\NavigationTrait;

class HomeController extends Controller
{
    use NavigationTrait;

    public function index()
    {
        $navData = $this->getNavigationData();
        $brands = Brand::all();
        $products = Product::with('brand', 'sale', 'platforms')->get();
        $platforms = Platform::take(4)->get();
        
        return view('index', array_merge($navData, compact('brands', 'products', 'platforms')));
    }
}
