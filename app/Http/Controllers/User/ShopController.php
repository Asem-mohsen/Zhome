<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Category;
use Carbon\Carbon;
use App\Models\Product;
use App\Models\Subcategory;
use App\Models\Promocode;
use App\Models\ProductTechnology;
use App\Models\Platform;
use App\Traits\NavigationTrait;

class ShopController extends Controller
{
    use NavigationTrait;

    protected $filterableFields = [
        'CategoryIDs' => 'array',
        'BrandIDs' => 'array',
        'PlatformIDs' => 'array',
        'TechnologyIDs' => 'array',
        'PriceBetween' => 'array',
    ];

    public function index()
    {
        $navData = $this->getNavigationData();
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
        return view('User.Shop.shop', array_merge($navData, compact('brands' , 'platforms','brand' , 'productsBrand' , 'category' , 'bundles' ,'categories' , 'productsOnSale' , 'promocodes','category2','categoriesProduct' , 'categoriesProduct2' , 'bundle' )) );
    }

    protected function getFilterData()
    {
        return [
            'categories'   => Category::with('subcategories')->get(),
            'brands'       => Brand::all(),
            'platforms'    => Platform::all(),
            'technologies' => ProductTechnology::distinct()->pluck('Technology'),
            'minPrice'     => Product::min('Price'),
            'maxPrice'     => Product::max('Price'),
        ];
    }

    protected function getCurrentFilters(Request $request)
    {
        $currentFilters = [];
        $filterData = $this->getFilterData();

        foreach ($this->filterableFields as $field => $type) {
            if ($type === 'array') {
                $currentFilters[$field] = $request->input($field)
                    ? explode(',', $request->input($field))
                    : [];
            } elseif ($field === 'PriceBetween') {
                $currentFilters[$field] = $request->input($field)
                    ? explode(',', $request->input($field))
                    : [$filterData['minPrice'], $filterData['maxPrice']];
            }
        }

        return $currentFilters;
    }

    protected function applyFilters($query, $currentFilters)
    {
        if (!empty($currentFilters['CategoryIDs'])) {
            $query->whereHas('subcategory', function ($q) use ($currentFilters) {
                $q->whereIn('MainCategoryID', $currentFilters['CategoryIDs']);
            });
        }

        if (!empty($currentFilters['BrandIDs'])) {
            $query->whereIn('BrandID', $currentFilters['BrandIDs']);
        }

        if (!empty($currentFilters['PlatformIDs'])) {
            $query->whereHas('platforms', function ($q) use ($currentFilters) {
                $q->whereIn('PlatformID', $currentFilters['PlatformIDs']);
            });
        }

        if (!empty($currentFilters['TechnologyIDs'])) {
            $query->whereHas('technologies', function ($q) use ($currentFilters) {
                $q->whereIn('Technology', $currentFilters['TechnologyIDs']);
            });
        }

        if (!empty($currentFilters['PriceBetween'])) {
            $query->whereBetween('Price', $currentFilters['PriceBetween']);
        }

        return $query;
    }

    public function filterIndex(Request $request)
    {
        $filterData = $this->getFilterData();
        $currentFilters = $this->getCurrentFilters($request);

        $query = Product::with(['brand', 'subcategory.category']);
        $query = $this->applyFilters($query, $currentFilters);
        $products = $query->paginate(12);

        return view('User.Shop.filterIndex', array_merge($filterData, compact('products', 'currentFilters')));
    }

    public function categoryFilter($id)
    {
        $filterData = $this->getFilterData();

        $category = Category::findOrFail($id);
        $subcategories = $category->subcategories;
        $products = Product::whereHas('subcategory', function ($query) use ($id) {
            $query->where('MainCategoryID', $id);
        })->paginate(12);

        $currentFilters = ['CategoryIDs' => [$id]];

        return view('User.Shop.category_filter', array_merge($filterData, compact('category', 'subcategories', 'products', 'currentFilters')));
    }

    public function subcategoryFilter($id)
    {
        $filterData = $this->getFilterData();

        $subcategory = Subcategory::findOrFail($id);
        $category = $subcategory->category;
        $products = Product::where('SubCategoryID', $id)->paginate(12);

        $currentFilters = ['CategoryIDs' => [$category->ID]];

        return view('User.Shop.subcategory_filter', array_merge($filterData, compact('subcategory', 'products', 'category', 'currentFilters')));
    }

    public function brandFilter($id)
    {
        $filterData = $this->getFilterData();

        $brand = Brand::findOrFail($id);
        $products = Product::where('BrandID', $id)->paginate(12);
        $otherBrands = Brand::where('ID', '!=', $id)->get();

        $currentFilters = ['BrandIDs' => [$id]];

        return view('User.Shop.brand_filter', array_merge($filterData, compact('brand', 'products', 'otherBrands', 'currentFilters')));
    }

    public function platformFilter($id)
    {
        $filterData = $this->getFilterData();

        $platform = Platform::findOrFail($id);
        $products = Product::whereHas('platforms', function ($query) use ($id) {
                        $query->where('PlatformID', $id);
                    })->paginate(12);
        $otherPlatforms = Platform::where('ID', '!=', $id)->get();

        $currentFilters = ['PlatformIDs' => [$id]];

        return view('User.Shop.platform_filter', array_merge($filterData, compact('platform', 'products', 'otherPlatforms', 'currentFilters')));
    }
}
