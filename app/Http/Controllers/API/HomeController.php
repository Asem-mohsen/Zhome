<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\BrandResource;
use App\Http\Resources\PlatformResource;
use App\Http\Resources\ProductCardResource;
use App\Models\Brand;
use App\Models\Platform;
use App\Models\Product;
use App\Traits\ApiResponse;

class HomeController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $brands = Brand::all();
        $products = Product::with(['brand', 'platforms'])->get();
        $platforms = Platform::all();

        $data = [
            'brands' => BrandResource::collection($brands),
            'products' => ProductCardResource::collection($products),
            'platforms' => PlatformResource::collection($platforms),
        ];

        return $this->data($data, 'Home data retrived successfully');
    }
}
