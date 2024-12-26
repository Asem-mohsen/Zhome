<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\{BrandResource, ProductCardResource, PlatformResource};
use App\Models\{Brand, Platform ,Product};

class HomeController extends Controller
{
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

        return successResponse($data, 'Home data retrived successfully');
    }
}
