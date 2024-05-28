<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductImages;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Product;
use App\Models\Platform;
use App\Models\Brand;
use App\Models\Features;
use App\Models\ProductEvaluation;
use App\Models\ProductFaq;
use App\Models\ProductDetails;
use App\Http\Requests\Admin\AddProductRequest;
use App\Http\Requests\Admin\UpdateProductRequest;
use App\Http\Services\Media;
use App\Http\Services\SyncChoices;
use App\Models\ProductFeatures;
use App\Models\ProductPlatforms;
use App\Models\ProductTechnology;


class ProductController extends Controller
{
    public function index(){
        $products = Product::with(['brand', 'platforms', 'subcategory.category'])->get();
        $platforms = [];
        foreach($products as $product){
            $productplatforms = ProductPlatforms::where('ProductID' , $product->ID);
            $platforms[] = $productplatforms;
        }
        
        return view('Admin.Products.index' , compact('products','platforms'));
    }

    public function create(){
        $products   = Product::all();
        $brands     = Brand::all();
        $platforms  = Platform::all();
        $categories = Category::all();
        $subs       = Subcategory::all();
        $features   = Features::all();

        return view('Admin.Products.create' , compact('products','brands','platforms','categories','subs','features'));
    }

    
    public function getSubcategories($categoryId)
    {
        $subcategories = SubCategory::where('MainCategoryID', $categoryId)->get();
        return response()->json($subcategories);
    }

    public function store(AddProductRequest $request)
    {

        $mainImageName = Media::upload($request->file('MainImage'), 'Admin\dist\img\web\Products\MainImage');
        $coverImageName = Media::upload($request->file('CoverImage'), 'Admin\dist\img\web\Products\CoverImage');

        $productData           = $request->only('Name','ArabicName','Description','ArabicDescription','Price','Quantity','InstallationCost','SubCategoryID','BrandID','IsBundle');
        $productDetailsData    = $request->only('Title','Title2','ArabicTitle','ArabicTitle2','Video','Width','Height','Length','Color','Capacity','PowerConsumption','Weight');
        $productPlatformsData  = $request->only('PlatformID');
        $productTechnologyData = $request->only('Technology');
        $productFeatureData    = $request->only('FeatureID');
        $productFAQData        = $request->only('Question','Answer');
        $productEvaluationData = $request->only('Evaluation','ArabicEvaluation');

        // Create Product
        $productData['MainImage'] = $mainImageName;
        $product = Product::create($productData);



        // Create ProductImages 
        $productImagesData['ProductID'] = $product->id;
        if ($request->hasFile('OtherImages')) {
            foreach ($request->file('OtherImages') as $otherImage) {
                $otherImagesName = Media::upload($otherImage, 'Admin\dist\img\web\Products\OtherImages');
                $productImagesData['Image'] = $otherImagesName;
                ProductImages::create($productImagesData);
            }
        }

        // Create ProductDetails
        $productDetailsData['ProductID'] = $product->id;
        $productDetailsData['CoverImage'] = $coverImageName;
        ProductDetails::create($productDetailsData);

        // Create ProductPlatforms
        $productPlatformsData['ProductID'] = $product->id;
        foreach ($request->PlatformID as $platforms) {
            $productPlatformsData['PlatformID'] = $platforms;
            ProductPlatforms::create($productPlatformsData);
        }

        // Create ProductTechnology
        $productTechnologyData['ProductID'] = $product->id;
        foreach ($request->Technology as $Technology) {
            $productTechnologyData['Technology'] = $Technology;
            ProductTechnology::create($productTechnologyData);
        }

        // Create Feature
        $productFeatureData['ProductID'] = $product->id;
        foreach ($request->FeatureID as $Feature) {
            $productFeatureData['FeatureID'] = $Feature;
            ProductFeatures::create($productFeatureData);
        }

        // Create Product Evaluation
        $productEvaluationData['ProductID'] = $product->id;
        ProductEvaluation::create($productEvaluationData);
        
        // Create Product FAQ
        $productFAQData['ProductID'] = $product->id;
        $questions = $request->Question;
        $answers = $request->Answer;

        if (count($questions) === count($answers)) {
            foreach ($questions as $index => $question) {
                $faqData = [
                    'Question' => $question,
                    'Answer' => $answers[$index],
                        'ProductID' => $product->id,
                    ];
                    ProductFaq::create($faqData);
            }
        } else {
            return redirect()->back()->with('success', 'The number of questions and answers do not match.');
        }

        return redirect()->route('Products.index')->with('success', 'Product Added Successfully');
    }

    public function update(UpdateProductRequest $request , Product $product, ProductDetails $details , ProductImages $images){
        $productDetails = $details::where('ProductID' , $product->ID)->first();
        $otherImages = $images::where('ProductID' , $product->ID)->first();

        $productData           = $request->only('Name','ArabicName','Description','ArabicDescription','Price','Quantity','InstallationCost','SubCategoryID','BrandID','IsBundle');
        $productDetailsData    = $request->only('Title','Title2','ArabicTitle','ArabicTitle2','Video','Width','Height','Length','Color','Capacity','PowerConsumption','Weight');
        $productPlatformsData  = $request->only('PlatformID');
        $productTechnologyData = $request->only('Technology');
        $productFeatureData    = $request->only('FeatureID');
        $productFAQData        = $request->only('Question','Answer');
        $productEvaluationData = $request->only('Evaluation','ArabicEvaluation');

        if($request->hasFile('MainImage')){
            $mainImageName = Media::upload($request->file('MainImage') , 'Admin\dist\img\web\Products\MainImage');
            $data['MainImage'] = $mainImageName;
            Media::delete(public_path("Admin\dist\img\web\Products\MainImage\\{$product->MainImage}"));
            $productData['MainImage'] = $mainImageName;
        }
        if($request->hasFile('CoverImage')){
            $coverImageName = Media::upload($request->file('CoverImage') , 'Admin\dist\img\web\Products\CoverImage');
            $data['CoverImage'] = $coverImageName;
            Media::delete(public_path("Admin\dist\img\web\Products\CoverImage\\{$productDetails->CoverImage}"));
            $productDetailsData['CoverImage'] = $coverImageName;
        }

        // Update Product
        $product::where('ID' , $product->ID)->update($productData);

        // Update ProductImages
        $productImagesData['ProductID'] = $product->ID;
        if ($request->hasFile('OtherImages')) {
            foreach ($request->file('OtherImages') as $otherImage) {
                $otherImagesName = Media::upload($request->file('CoverImage') , 'Admin\dist\img\web\Products\OtherImages');
                $productImagesData['Image'] = $otherImagesName;
                Media::delete(public_path("Admin\dist\img\web\Products\OtherImages\\{$otherImages->Image}"));
                ProductImages::where('ProductID' , $product->ID)->update($productImagesData);
            }
        }

        // Update ProductDetails
        $productDetailsData['ProductID'] = $product->ID;
        ProductDetails::where('ProductID' , $product->ID)->update($productDetailsData);

        // Update ProductPlatforms
        SyncChoices::Sync(ProductPlatforms::class , $product->ID , $request->PlatformID , 'PlatformID');

        // Update ProductTechnology
        SyncChoices::Sync(ProductTechnology::class , $product->ID , $request->Technology , 'Technology' );

        // Update Feature
        SyncChoices::Sync(ProductFeatures::class , $product->ID , $request->FeatureID , 'FeatureID' );

        // Update Product Evaluation
        $productEvaluationData['ProductID'] = $product->ID;
        ProductEvaluation::where('ProductID' , $product->ID)->update($productEvaluationData);

        // Update Product FAQ
        $productFAQData['ProductID'] = $product->ID;
        $questions = $request->Question;
        $answers = $request->Answer;

        foreach ($questions as $index => $question) {
            $faqData = [
                'Question' => $question,
                'Answer' => $answers[$index],
                    'ProductID' => $product->ID,
                ];
                ProductFaq::where('ProductID' , $product->ID)->update($faqData);
        }

        return redirect()->route('Products.show' , $product->ID)->with('success', 'Product Updated Successfully');
    }

    public function show(Product $product){
        $product::with(['brand', 'platforms', 'subcategory.category','faqs','images' ,'technologies', 'features', 'sale', 'collections' , 'evaluations' , 'productDetails'])->first();
        return view('Admin.Products.show' , compact('product'));
    }

    public function edit(Product $product){
        $product::with(['brand', 'platforms', 'subcategory.category','faqs','images' ,'technologies', 'features', 'sale', 'collections' , 'evaluations' , 'productDetails'])->findOrFail($product->ID);
        $brands     = Brand::all();
        $platforms  = Platform::all();
        $categories = Category::all();
        $subs       = Subcategory::all();
        $features   = Features::all();
        return view('Admin.Products.edit' , compact('product','brands','platforms','categories','subs','features'));
    }

    public function destroy(Product $product){

        // Delete platforms
        ProductPlatforms::where('ProductID',$product->ID)->delete();

        // Delete related FAQs
        ProductFaq::where('ProductID',$product->ID)->delete();

        // Delete related images
        ProductImages::where('ProductID',$product->ID)->delete();

        // Delete related technologies
        ProductTechnology::where('ProductID',$product->ID)->delete();

        // Delete related features
        ProductFeatures::where('ProductID',$product->ID)->delete();

        // Delete related Details
        ProductDetails::where('ProductID',$product->ID)->delete();

        // Delete related Evaluations
        ProductEvaluation::where('ProductID',$product->ID)->delete();

        $product->where('ID',$product->ID)->delete();

        return redirect()->back()->with('success', 'product Deleted Successfully');
            
    }

}