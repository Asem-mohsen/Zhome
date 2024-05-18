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

class ProductController extends Controller
{
    public function index(){
        $products = Product::with(['brand', 'platforms', 'subcategory.category'])->get();
        return view('Admin.Products.index' , compact('products'));
    }

    public function show(){
        $products = Product::with(['brand', 'platforms', 'subcategory.category','faqs','images' ,'technologies', 'features'])->get();
        return view('Admin.Products.show' , compact('products'));
    }
}
