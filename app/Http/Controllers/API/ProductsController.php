<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
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
use App\Models\Admin;
use App\Http\Requests\Admin\AddProductRequest;
use App\Http\Requests\Admin\UpdateProductRequest;
use App\Http\Services\Media;
use App\Http\Services\SyncChoices;
use App\Models\ProductFeatures;
use App\Models\ProductPlatforms;
use App\Models\ProductTechnology;
use App\Traits\ApiResponse;


class ProductController extends Controller
{
    use ApiResponse;

    public function index(){

        $products = Product::with(['brand', 'platforms', 'subcategory.category'])->get();
        
        $platforms = [];
        
        foreach($products as $product){
            
            $productplatforms = ProductPlatforms::where('ProductID' , $product->ID);
            
            $platforms[] = $productplatforms;

        }

        $data = [
            'products'  => $products,
            'platforms' => $platforms,
        ];

        return $this->data($data, 'All Products data retrieved successfully');

    }

    public function create(){

        $products   = Product::all();
        $brands     = Brand::all();
        $platforms  = Platform::all();
        $categories = Category::all();
        $subs       = Subcategory::all();
        $features   = Features::all();

        $data = [
            'products '  => $products,
            'brands'     => $brands,
            'platforms'  => $platforms,
            'categories' => $categories,
            'features'   => $features,
            'subs'       => $subs,
        ];

        return $this->data($data, 'All Products data retrieved successfully');

    }

    public function getSubcategories($categoryId)
    {

        $subcategories = SubCategory::where('MainCategoryID', $categoryId)->get();

        return response()->json($subcategories);

    }

    public function store(AddProductRequest $request)
    {
        $mainImageName  = Media::upload($request->file('MainImage'), 'Admin\dist\img\web\Products\MainImage');
        $coverImageName = Media::upload($request->file('CoverImage'),'Admin\dist\img\web\Products\CoverImage');

        $productData           = $request->only('Name','ArabicName','Description','ArabicDescription','Price','Quantity','InstallationCost','SubCategoryID','BrandID','IsBundle');
        $productDetailsData    = $request->only('Title','Title2','ArabicTitle','ArabicTitle2','Video','Width','Height','Length','Color','Capacity','PowerConsumption','Weight');
        $productPlatformsData  = $request->only('PlatformID');
        $productTechnologyData = $request->only('Technology');
        $productFeatureData    = $request->only('FeatureID');
        $faqData               = $request->only(['Question', 'Answer', 'ArabicQuestion', 'ArabicAnswer']);
        $productEvaluationData = $request->only('Evaluation','ArabicEvaluation');
        
        $colorData = [
                'Color' => $request->input('Color'),
                'Color2' => $request->input('Color2'),
                'Color3' => $request->input('Color3')
            ];

        $colorData = array_filter($colorData, function($value) {
            return !is_null($value);
        });

        // Create Product
        $productData['MainImage'] = $mainImageName;
        $productData['AddedBy'] = Auth::guard('admin')->user()->id;
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
        $productDetailsData['Color']  = $colorData['Color'] ?? null;
        $productDetailsData['Color2'] = $colorData['Color2'] ?? null;
        $productDetailsData['Color3'] = $colorData['Color3'] ?? null;
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
        if ($request->has('FeatureID')) {
            $productFeatureData['ProductID'] = $product->id;
            foreach ($request->FeatureID as $Feature) {
                $productFeatureData['FeatureID'] = $Feature;
                ProductFeatures::create($productFeatureData);
            }
        }

        // Create Product Evaluation
        $productEvaluationData['ProductID'] = $product->id;
        $productEvaluationData['ExpertID'] = Auth::guard('admin')->user()->id;
        ProductEvaluation::create($productEvaluationData);

        // Create Product FAQ
        foreach ($faqData['Question'] as $index => $question) {
            $faq = new ProductFaq();
            $faq['ProductID']    = $product->id;
            $faq->Question       = $question;
            $faq->Answer         = $faqData['Answer'][$index] ?? null;
            $faq->ArabicQuestion = $faqData['ArabicQuestion'][$index] ?? null;
            $faq->ArabicAnswer   = $faqData['ArabicAnswer'][$index] ?? null;
            $faq->save();
        }

        return $this->success('Product Added Successfully');

    }

    public function update(UpdateProductRequest $request , Product $product, ProductDetails $details , ProductImages $images){
        $productDetails = $details::where('ProductID' , $product->ID)->first();

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
            $oldCoverImagePath = public_path("Admin/dist/img/web/Products/CoverImage/{$productDetails->CoverImage}");
            if (is_file($oldCoverImagePath)) {
                Media::delete($oldCoverImagePath);
            }
            $productDetailsData['CoverImage'] = $coverImageName;
        }

        // Update Product
        $product::where('ID' , $product->ID)->update($productData);

        // Update ProductImages
        $productImagesData['ProductID'] = $product->ID;
        if ($request->hasFile('OtherImages')) {

            $existingImages = ProductImages::where('ProductID' , $product->ID)->get();
            foreach ($existingImages as $existingImage) {
                $oldImagePath = public_path("Admin/dist/img/web/Products/OtherImages/{$existingImage->Image}");
                if (is_file($oldImagePath)) {
                    Media::delete($oldImagePath);
                }
                $existingImage::where('ProductID' , $product->ID)->delete();
            }
            foreach ($request->file('OtherImages') as $otherImage) {
                $otherImagesName = Media::upload($otherImage , 'Admin\dist\img\web\Products\OtherImages');
                $productImagesData['Image'] = $otherImagesName;
                ProductImages::create($productImagesData);
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

        return $this->success('Product Updated Successfully');

    }

    public function show(Product $product){

        $product::with(['brand', 'platforms', 'subcategory.category','faqs','images' ,'technologies', 'features', 'sale', 'collections' , 'evaluations.admin' , 'productDetails'])->first();
        
        $data = [
            'product' => $product,
        ];

        return $this->data($data, 'Product data retrieved successfully');

    }

    public function userShow(Product $product)
    {
        $product::with(['brand', 'platforms', 'subcategory.category','faqs','images' ,'technologies', 'features', 'sale', 'collections' , 'evaluations.admin' , 'productDetails'])->first();
        
        $products = Product::with(['brand', 'platforms', 'subcategory.category'])->get();

        $data = [
            'products' => $products,
            'product' => $product,
        ];

        return $this->data($data, 'Product data retrieved successfully');
    }

    public function edit(Product $product)
    {

        $product::with(['brand', 'platforms', 'subcategory.category','faqs','images' ,'technologies', 'features', 'sale', 'collections' , 'evaluations' , 'productDetails'])->findOrFail($product->ID);
        
        $brands     = Brand::all();
        $platforms  = Platform::all();
        $categories = Category::all();
        $subs       = Subcategory::all();
        $features   = Features::all();

        $data = [
            'product'   => $product,
            'brands'    => $brands,
            'platforms' => $platforms,
            'categories'=> $categories,
            'subs'      => $subs,
            'features'  => $features,
        ];

        return $this->data($data, 'Product data for editing retrieved successfully');

    }

    public function destroy(Product $product)
    {

        try {

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

            return $this->success('Product Deleted Successfully');

        } catch (\Exception $e) {

            return $this->error(['delete_error' => $e->getMessage()], 'Failed to delete Product');
        
        }



    }

}
