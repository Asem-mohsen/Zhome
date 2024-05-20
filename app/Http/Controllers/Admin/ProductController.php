<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Product;
use App\Models\Platform;
use App\Models\Brand;
use App\Models\ProductDetails;
use App\Http\Requests\Admin\AddProductRequest;
use App\Http\Requests\Admin\UpdateProductRequest;
use App\Http\Services\Media;
use App\Models\ProductFeatures;
use App\Models\ProductPlatforms;
use App\Models\ProductTechnology;


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

    public function store(AddProductRequest $request){

        $mainImageName = Media::upload($request->file('MainImage'), 'Admin\dist\img\web\Products\MainImage');
        $coverImageName = Media::upload($request->file('CoverImage'), 'Admin\dist\img\web\Products\CoverImage');

        $otherImagesNames = [];
        if ($request->hasFile('OtherImages')) {
            foreach ($request->file('OtherImages') as $otherImage) {
                $otherImagesNames[] = Media::upload($otherImage, 'Admin\dist\img\web\Products\OtherImages');
            }
        }

        $productData           = $request->except('MainImage','CoverImage','OtherImages','_token','_method');
        $productDetailsData    = $request->only('');
        $productPlatformsData  = $request->only('Platform');
        $productTechnologyData = $request->only('Technology');

        // Create Product
        $productData['MainImage'] = $mainImageName;
        $product = Product::create($productData);

        // Create ProductDetails
        $productDetailsData['ProductID'] = $product->id;
        $productDetailsData['CoverImage'] = $coverImageName;
        $productDetails = ProductDetails::create($productDetailsData);

        // Create ProductPlatforms
        $productPlatformsData['ProductID'] = $product->id;
        $producPlatforms = ProductPlatforms::create($productPlatformsData);

        // Create ProductTechnology
        $productTechnologyData['ProductID'] = $product->id;
        $producTechnology = ProductTechnology::create($productTechnologyData);

        return redirect()->route('Product.index')->with('success', 'Product Added Successfully');
    }

    public function show(){
        $products = Product::with(['brand', 'platforms', 'subcategory.category','faqs','images' ,'technologies', 'features'])->get();
        return view('Admin.Products.show' , compact('products'));
    }
}
