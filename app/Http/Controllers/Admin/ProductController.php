<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Product;
use App\Models\Platform;
use App\Models\Brand;
use App\Http\Requests\Admin\AddProductRequest;
use App\Http\Requests\Admin\UpdateProductRequest;
use App\Http\Services\Media;
use App\Models\ProductFeatures;

class ProductController extends Controller
{
    public function index(){
        $products = Product::with(['brand', 'platforms', 'subcategory.category'])->get();
        return view('Admin.Products.index' , compact('products'));
    }
    
    public function create(){
        $products   = Product::all();
        $brands     = Brand::all();
        $platforms  = Platform::all();
        $categories = Category::all();
        $subs       = Subcategory::all();
        $features   = ProductFeatures::all();
        
        return view('Admin.Products.create' , compact('products','brands','platforms','categories','subs','features'));
    }
    
    public function getSubcategories($categoryId)
    {
        $subcategories = SubCategory::where('MainCategoryID', $categoryId)->get();
        return response()->json($subcategories);
    }

    public function show(){
        $products = Product::with(['brand', 'platforms', 'subcategory.category','faqs','images' ,'technologies', 'features'])->get();
        return view('Admin.Products.show' , compact('products'));
    }
}