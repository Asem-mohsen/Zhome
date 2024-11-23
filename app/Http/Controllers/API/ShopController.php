<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\{ Brand , Category , Platform , Product , Promotion , Technology };
use App\Traits\ApiResponse;
use App\Traits\NavigationTrait;
use Illuminate\Http\Request;
class ShopController extends Controller
{
    use ApiResponse , NavigationTrait;

    // protected $filterableFields = [
    //     'CategoryIDs' => 'array',
    //     'BrandIDs' => 'array',
    //     'PlatformIDs' => 'array',
    //     'TechnologyIDs' => 'array',
    //     'PriceBetween' => 'array',
    // ];

    public function index()
    {
        $data = [
            'brands' => $this->getAllBrands(),
            'platforms' => $this->getAllPlatforms(),
            'categories' => $this->getAllCategories(),
            'bundles' => $this->getBundles(),
            'onSale' => $this->getOnSaleProducts(),
            'promotions' => $this->getActivePromotions(),
            'Bundle_to_Show' => $this->getFirstBundle(),
            'Brand_to_show' => $this->getBrandWithProducts(1),
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
        return Brand::Select('id' , 'name')->get();
    }

    protected function getAllPlatforms()
    {
        return Platform::Select('id' , 'name')->get();
    }

    protected function getAllCategories()
    {
        return Category::select('id' , 'name', 'ar_name')->get();
    }

    protected function getAllTechnologies()
    {
        return Technology::select('id' , 'name', 'ar_name')->get();
    }

    // Getters for specific selections
    protected function getBrandWithProducts($brandId)
    {
        return Brand::with(['products.translations', 'products.brand', 'products.platforms'])->find($brandId);
    }

    protected function getCategoryWithSubcategories($categoryId)
    {
        return Category::with([
            'subcategories',
            'products' => function ($query) {
                $query->with(['brand', 'platforms', 'translations']);
            },
        ])->find($categoryId);
    }

    protected function getBundles()
    {
        return Product::with(['brand:name,id', 'platforms:name,id', 'sale', 'subcategory:name,id,category_id,ar_name', 'subcategory.category:name,id,ar_name', 'translations:name,ar_name,product_id,id'])
            ->where('is_bundle', true)
            ->limit(3)
            ->get();
    }

    protected function getOnSaleProducts()
    {
        return Product::with(['sale', 'brand:name,id', 'platforms:name,id', 'translations:name,ar_name,product_id,id'])
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
        return Product::with(['brand:name,id', 'platforms:name,id', 'sale', 'subcategory:name,id,category_id,ar_name','subcategory:name,id,category_id,ar_name', 'translations:name,ar_name,product_id,id'])
            ->where('is_bundle', true)
            ->first();
    }

    protected function getFilterData()
    {
        return [
            'categories' => Category::with('subcategories:name,ar_name,category_id,id')->select('name' , 'ar_name' , 'id')->get(),
            'brands' => $this->getAllBrands(),
            'platforms' => $this->getAllPlatforms(),
            'technologies' => $this->getAllTechnologies(),
            'minPrice' => Product::min('price'),
            'maxPrice' => Product::max('price'),
        ];
    }

    // protected function getCurrentFilters(Request $request)
    // {
    //     $currentFilters = [];
    //     $filterData = $this->getFilterData();

    //     foreach ($this->filterableFields as $field => $type) {
    //         if ($type === 'array') {
    //             $currentFilters[$field] = $request->input($field)
    //                 ? explode(',', $request->input($field))
    //                 : [];
    //         } elseif ($field === 'PriceBetween') {
    //             $currentFilters[$field] = $request->input($field)
    //                 ? explode(',', $request->input($field))
    //                 : [$filterData['minPrice'], $filterData['maxPrice']];
    //         }
    //     }

    //     return $currentFilters;
    // }
    public function filterIndex(Request $request)
    {
        $filterData = $this->getFilterData();
        // $currentFilters = $this->getCurrentFilters($request);

        $query = Product::with(['brand:name,id', 'platforms:name,id', 'subcategory:name,id,category_id,ar_name','subcategory:name,id,category_id,ar_name', 'translations:name,ar_name,product_id,id', 'sale', 'technologies:name,ar_name,id']);
        // $query = $this->applyFilters($query, $currentFilters);
        $products = $query->paginate(12);
        $data = [
            'Filter_Data' => $filterData,
            'products' => $products,
        ];

        return $this->data($data, 'data retrieved successfully');
    }

    // public function fetchFilter($type, $id)
    // {
    //     if ($type === 'brand') {
            
    //         $brand = Brand::find($id);
            
    //         if ($brand) {
                                
    //             return $this->data(compact('brand'), 'data retrieved successfully');
 
    //         } else {
                
    //             return $this->error(['error' => 'Brand not found'], 404);
                
    //         }
    //     } elseif ($type === 'category') {

    //         $category = Category::with('subcategories:name,ar_name,id,category_id')->find($id);
           
    //         if ($category) {
                                
    //             return $this->data(compact('category'), 'data retrieved successfully');
                
    //         } else {
    //            return $this->error(['error' => 'category not found'], 404);
    //         }
    //     } elseif ($type === 'platform') {

    //         $platform = Platform::find($id);
           
    //         if ($platform) {
                                
    //             return $this->data(compact('platform'), 'data retrieved successfully');
                
    //         } else {
    //            return $this->error(['error' => 'Platform not found'], 404);
    //         }
            
    //     } else {
    //         return response()->json(['error' => 'Invalid type'], 400);
    //     }
    
    // }

    // protected function applyFilters($query, $currentFilters)
    // {
    //     if (!empty($currentFilters['CategoryIDs'])) {
    //         $query->whereHas('subcategory', function ($q) use ($currentFilters) {
    //             $q->whereIn('MainCategoryID', $currentFilters['CategoryIDs']);
    //         });
    //     }

    //     if (!empty($currentFilters['BrandIDs'])) {
    //         $query->whereIn('BrandID', $currentFilters['BrandIDs']);
    //     }

    //     if (!empty($currentFilters['PlatformIDs'])) {
    //         $query->whereHas('platforms', function ($q) use ($currentFilters) {
    //             $q->whereIn('PlatformID', $currentFilters['PlatformIDs']);
    //         });
    //     }

    //     if (!empty($currentFilters['TechnologyIDs'])) {
    //         $query->whereHas('technologies', function ($q) use ($currentFilters) {
    //             $q->whereIn('Technology', $currentFilters['TechnologyIDs']);
    //         });
    //     }

    //     if (!empty($currentFilters['PriceBetween'])) {
    //         $query->whereBetween('Price', $currentFilters['PriceBetween']);
    //     }

    //     return $query;
    // }

    public function filterProducts(Request $request)
    {
        $query = Product::query();
    
        if ($request->has('categories')) {
            $categoryIds = explode(',', $request->input('categories'));
            $query->whereHas('subcategory', function ($q) use ($categoryIds) {
                $q->whereIn('category_id', $categoryIds);
            });
        }
    
        if ($request->has('brands')) {
            $brandIds = explode(',', $request->input('brands'));
            $query->whereIn('brand_id', $brandIds);
        }
    
        if ($request->has('platforms')) {
            $platformIds = explode(',', $request->input('platforms'));
            $query->whereHas('platforms', function ($q) use ($platformIds) {
                $q->whereIn('id', $platformIds);
            });
        }
    
        if ($request->has('technologies')) {
            $technologyIds = explode(',', $request->input('technologies'));
            $query->whereHas('technologies', function ($q) use ($technologyIds) {
                $q->whereIn('id', $technologyIds);
            });
        }
    
        if ($request->has('price')) {
            $priceRange = explode(',', $request->input('price'));
            if (count($priceRange) === 2) {
                $query->whereBetween('price', [$priceRange[0], $priceRange[1]]);
            }
        }
    
        if ($request->has('sort')) {
            $sortBy = $request->input('sort');
            $sortDirection = $request->input('direction', 'asc'); // Default to ascending
            $query->orderBy($sortBy, $sortDirection);
        }
    
        $products = $query->with(['brand:name,id', 'platforms:name,id', 'subcategory:name,ar_name,category_id,id', 'technologies:name,ar_name,id' , 'translations:name,ar_name,product_id,id'])->paginate(12);
    
        $filterData = [
            'categories' => Category::select('id', 'name')->get(),
            'brands' => Brand::select('id', 'name')->get(),
            'platforms' => Platform::select('id', 'name')->get(),
            'technologies' => Technology::select('id', 'name')->get(),
            'minPrice' => Product::min('price'),
            'maxPrice' => Product::max('price'),
        ];
    
        $data = [
            'products'    => $products,
            'Filter_Data' => $filterData,
        ];

        return $this->data($data , 'filtered data retrived successfully');
    }

    public function getItemByTypeAndId(Request $request)
    {
        $type = $request->input('type');
        $id = $request->input('id');

        if (!$type || !$id) {
            return $this->error(['error' => 'Type and ID are required'], "Type and ID are required");
        }

        $data = null;

        switch ($type) {
            case 'platform':
                $data = Platform::find($id);
                break;
            case 'brand':
                $data = Brand::find($id);
                break;
            case 'category':
                $data = Category::with('subcategories')->find($id);
                break;
            default:
                return response()->json(['error' => 'Invalid type'], 400);
        }

        if (!$data) {
            return response()->json(['error' => ucfirst($type) . ' not found'], 404);
        }

        return $this->data(['type' => $type, 'data' => $data], 'data retrieved successfully');
    }

    public function navData()
    {
        $data = [
            'navbar_data' => $this->getNavigationData(),
        ];

        return $this->data($data, 'data retrieved successfully');
    }
}
