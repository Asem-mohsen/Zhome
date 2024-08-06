<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Platform;
use App\Models\Product;
use App\Traits\NavigationTrait;
use App\Traits\ApiResponse;

class HomeController extends Controller
{
    use NavigationTrait , ApiResponse;


    public function index()
    {
        $navData = $this->getNavigationData();
        $brands = Brand::all();
        $products = Product::with('brand', 'sale', 'platforms')->get();
        $platforms = Platform::take(4)->get();

        $data = [
            "Brands"   => $brands,
            "products" => $products,
            "platforms"=> $platforms,
            "navData" => $navData,
        ];

        return $this->data($data , 'Home data retrived successfully');

    }

}