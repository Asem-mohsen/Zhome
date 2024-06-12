<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Platform;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $brands = Brand::all();
        $products = Product::with('brand', 'sale' , 'platforms')->get();
        $platforms =  Platform::take(4)->get();
        return view('index' , compact('brands' , 'products' , 'platforms'));
    }
}