<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Brand ,Category, Product , Promotion , Subcategory , Technology , Platform};
use Carbon\Carbon;
use App\Traits\NavigationTrait;
use App\Traits\ApiResponse;

class ShopController extends Controller
{
    use ApiResponse , NavigationTrait;

    public function index()
    {
        $data = [
            'brands'         => $this->getAllBrands(),
            'platforms'      => $this->getAllPlatforms(),
            'categories'     => $this->getAllCategories(),
            'bundles'        => $this->getBundles(),
            'onSale'         => $this->getOnSaleProducts(),
            'promotions'     => $this->getActivePromotions(),
            'Bundle_to_Show' => $this->getFirstBundle(),
            'Brand_to_show'  => $this->getBrandWithProducts(1),
            'Category1_to_show' => $this->getCategoryWithSubcategories(4),
            'Category2_to_show' => $this->getCategoryWithSubcategories(3),
        ];

        return $this->data($data, 'Data retrieved successfully');
    }

    protected function getCategoriesWithSubcategories()
    {
        return Category::whereHas('subcategories.products')
                        ->with(['subcategories' => function ($query) {
                            $query->whereHas('products');
                        }])->get();
    }

    protected function getAllBrands()
    {
        return Brand::all();
    }

    protected function getAllPlatforms()
    {
        return Platform::all();
    }

    protected function getAllCategories()
    {
        return Category::all();
    }

    // Getters for specific selections
    protected function getBrandWithProducts($brandId)
    {
        return Brand::with(['products.translations','products.brand','products.platforms'])->find($brandId);
    }

    protected function getCategoryWithSubcategories($categoryId)
    {
        return Category::with([
            'subcategories',
            'products' => function ($query) {
                $query->with(['brand', 'platforms', 'translations']);
            }
        ])->find($categoryId);
    }

    protected function getBundles()
    {
        return Product::with(['brand', 'platforms', 'sale', 'subcategory.category', 'translations'])
                    ->where('is_bundle', true)
                    ->limit(3)
                    ->get();
    }

    protected function getOnSaleProducts()
    {
        return Product::with(['sale', 'brand', 'platforms', 'translations'])
                    ->whereHas('sale', function ($query) {
                        $query->where('end_date', '>', now());
                    })
                    ->get();
    }

    protected function getActivePromotions()
    {
        return Promotion::where('valid_until', '>', now())
                        ->where('status', 'active')
                        ->orderBy('valid_until')
                        ->first();
    }

    protected function getFirstBundle()
    {
        return Product::with(['brand', 'platforms', 'sale', 'subcategory.category', 'translations'])
                    ->where('is_bundle', true)
                    ->first();
    }

    protected function getFilterData()
    {
        return [
            'categories'   => Category::with('subcategories')->get(),
            'brands'       => Brand::all(),
            'platforms'    => Platform::all(),
            'technologies' => Technology::all(),
            'minPrice'     => Product::min('price'),
            'maxPrice'     => Product::max('price'),
        ];
    }


    public function filterIndex(Request $request)
    {
        $filterData = $this->getFilterData();

        $query = Product::with(['brand', 'subcategory.category', 'platforms','sale' , 'technologies', 'translations' ]);
        $products = $query->paginate(12);

        $data = [
            "Filter_Data" => $filterData,
            "products" => $products,
        ];

        return $this->data($data, 'data retrieved successfully');
    }

    public function navData()
    {
        $data = [
            'navbar_data' => $this->getNavigationData(),
        ];

        return $this->data($data, 'data retrieved successfully');
    }
}
