<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\{ Brand , Category , Platform , Product , Promotion , Technology };
use App\Traits\NavigationTrait;
use Illuminate\Http\Request;
class ShopController extends Controller
{
    use  NavigationTrait;

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

        return successResponse($data, 'Data retrieved successfully');
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

    public function filterIndex(Request $request)
    {
        $filterData = $this->getFilterData();

        $query = Product::with(['brand:name,id', 'platforms:name,id', 'subcategory:name,id,category_id,ar_name','subcategory:name,id,category_id,ar_name', 'translations:name,ar_name,product_id,id', 'sale', 'technologies:name,ar_name,id']);
        $products = $query->paginate(12);
        $data = [
            'Filter_Data' => $filterData,
            'products' => $products,
        ];

        return successResponse($data , message: 'data retrieved successfully');
    }

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
            'filter_data' => $filterData,
        ];

        return successResponse($data , message: 'iltered data retrived successfully');
    }

    public function getItemByTypeAndId(Request $request)
    {
        $type = $request->input('type');
        $id = $request->input('id');

        if (!$type || !$id) {
            return failureResponse('Type and ID are required');
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
                return failureResponse('Invalid type' , 400);
        }

        if (!$data) {
            return failureResponse(ucfirst($type)  .' not found' , 404);
        }

        return successResponse(['type' => $type, 'data' => $data] , message: 'data retrieved successfully');
    }

    public function navData()
    {
        $data = [
            'navbar_data' => $this->getNavigationData(),
        ];

        return successResponse( $data , message: 'data retrieved successfully');
    }
}
