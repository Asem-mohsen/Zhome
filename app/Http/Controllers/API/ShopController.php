<?php

namespace App\Http\Controllers\API;

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
use App\Traits\ApiResponse;
use App\Traits\HandleImgPath;

class ShopController extends Controller
{
    use ApiResponse , NavigationTrait , HandleImgPath;


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
        $productsBrand = Product::with(['brand', 'platforms', 'subcategory.category' ,'sale'])
                        ->where('BrandID', $brand->ID)
                        ->get();

        // Selected category
        $category           = Category::with('subcategories')->findOrFail(4);
        $category2          = Category::with('subcategories')->findOrFail(3);
        $categoriesProduct  = Product::with(['brand', 'platforms', 'sale' , 'subcategory.category'])
                                ->whereHas('subcategory', function ($query) use ($category) {
                                    $query->where('MainCategoryID', $category->ID);
                                })
                                ->get();
        $categoriesProduct2 = Product::with(['brand', 'sale' , 'platforms', 'subcategory.category'])
                                ->whereHas('subcategory', function ($query) use ($category2) {
                                    $query->where('MainCategoryID', $category2->ID);
                                })
                                ->get();

        // All
        $brands    = Brand::all();
        $platforms = Platform::all();
        $categories= Category::all();

        // conditions
        $bundles        = Product::with(['brand', 'platforms','sale' ,  'subcategory.category'])->where('IsBundle' , '1')->limit(3)->get();
        $productsOnSale = Product::with(['sale', 'brand', 'platforms'])
                        ->whereHas('sale', function ($query) {
                            $query->where('EndDate', '>', Carbon::now()); // Assuming the sale model has an 'end_date' field
                        })
                        ->get();
        $promocodes     = Promocode::where('EndsIn', '>', $currentDate)->where('Status' , '1')->orderBy('EndsIn')->limit(1)->first();
        $bundle         = Product::with(['brand', 'platforms','sale' ,  'subcategory.category'])->where('IsBundle' , '1')->limit(1)->first();


        $data = [
            // 'Navbar data' => $navData,
            'All_Brands' => $this->transformImagePaths($brands),
            'All_Platforms' => $this->transformImagePaths($platforms),
            'All_Categories' => $this->transformImagePaths($categories),
            'All_Bundles' => $this->transformImagePaths($bundles),
            'All_Products_On_Sale' => $this->transformImagePaths($productsOnSale),
            'Promocode' => $promocodes,
            "Bundle_to_Show" => $this->transformImagePaths($bundle),
            'Brand_to_show' => [
                "Brand" => $this->transformImagePaths($brand),
                "Products" => $this->transformImagePaths($productsBrand)
            ],
            'Category1_to_show' => [
                "Category" => $this->transformImagePaths($category),
                "Products" => $this->transformImagePaths($categoriesProduct)
            ],
            'Category2_to_show' => [
                "Category" => $this->transformImagePaths($category2),
                "Products" => $this->transformImagePaths($categoriesProduct2)
            ],
        ];
        return $this->data($data , 'data retrieved successfully');
    }

    protected function transformAllData($data)
    {
        $transformed = [];
        foreach ($data as $key => $value) {
            if (is_array($value) || $value instanceof \Illuminate\Support\Collection) {
                $transformed[$key] = $this->transformImagePaths($value);
            } elseif ($value instanceof Model) {
                $transformed[$key] = $this->transformImagePaths($value);
            } else {
                $transformed[$key] = $value;
            }
        }
        return $transformed;
    }

    protected function getFilterData()
    {
        return [
            'categories'   => $this->transformImagePaths(Category::with('subcategories')->get()),
            'brands'       => $this->transformImagePaths(Brand::all()),
            'platforms'    => $this->transformImagePaths(Platform::all()),
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

        $query = Product::with(['brand', 'subcategory.category', 'platforms','sale' ]);
        $query = $this->applyFilters($query, $currentFilters);
        $products = $query->paginate(12);

        $data = [
            "Filter_Data" => $filterData,
            "products" => $this->transformImagePaths($products),
            "current_Filters" => $currentFilters,
        ];

        return $this->data($data, 'data retrieved successfully');
    }

    public function categoryFilter($id)
    {
       $filterData = $this->getFilterData();

        $category = Category::findOrFail($id);
        $subcategories = $category->subcategories;
        $products = Product::with(['brand','platforms','sale'])->whereHas('subcategory', function ($query) use ($id) {
            $query->where('MainCategoryID', $id);
        })->paginate(12);

        $currentFilters = ['CategoryIDs' => [$id]];

        $data = [
            "Filter_Data" => $filterData,
            'category' => $this->transformImagePaths($category),
            'products_of_the_category' => $this->transformImagePaths($products),
            "current_Filters" => $currentFilters,
        ];

        return $this->data($data, 'data retrieved successfully');
    }

    public function subcategoryFilter($id)
    {
       $filterData = $this->getFilterData();

        $subcategory = Subcategory::findOrFail($id);
        $category = $subcategory->category;
        $products = Product::with(['brand','platforms','sale'])->where('SubCategoryID', $id)->paginate(12);

        $currentFilters = ['CategoryIDs' => [$category->ID]];

        $data = [
            "Filter_Data" => $filterData,
            'subcategory' => $this->transformImagePaths($subcategory),
            'products_of_the_subcategory' => $this->transformImagePaths($products),
            "current_Filters" => $currentFilters,
        ];

        return $this->data($data , 'data retrieved successfully');

    }

    public function brandFilter($id)
    {
       $filterData = $this->getFilterData();

        $brand       = Brand::findOrFail($id);

        $products    = Product::with(['brand','platforms','sale'])->where('BrandID', $id)->paginate(12);

        $otherBrands = Brand::where('ID', '!=', $id)->get();

        $currentFilters = ['BrandIDs' => [$id]];

        $data = [
            "Filter_Data" => $filterData,
            'brand' => $this->transformImagePaths($brand),
            'products_of_the_brand' => $this->transformImagePaths($products),
            "current_Filters" => $currentFilters,
        ];

        return $this->data($data , 'data retrieved successfully');
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

        $data = [
            "Filter_Data" => $filterData,
            'platform' => $this->transformImagePaths($platform),
            'products_of_the_platform' => $this->transformImagePaths($products),
            'Other_Platforms'     => $this->transformImagePaths($otherPlatforms),
            "current_Filters" => $currentFilters,
        ];

        return $this->data($data , 'data retrieved successfully');
    }
}