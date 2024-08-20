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
use Illuminate\Support\Facades\App;
use App\Traits\HandleImgPath;

class ProductsController extends Controller
{
    use ApiResponse , HandleImgPath;

    public function index(){

        $products = Product::with(['brand', 'platforms', 'subcategory.category' , 'sale'])->get();

        $platforms = [];

        foreach($products as $product){

            $productplatforms = ProductPlatforms::where('ProductID' , $product->ID);

            $platforms[] = $productplatforms;

        }

        $transformedProducts = $this->transformImagePaths($products, [
            'MainImage' => ['path' => 'Admin/dist/img/web/Products/MainImage'],
        ]);

        $transformedProducts->transform(function ($product) {
            if ($product->brand) {
                $product->brand = $this->transformImagePaths($product->brand, [
                    'Logo' => ['path' => 'Admin/dist/img/web/Brands/'],
                ]);
            }

            return $product;
        });
        
        $data = [
            'products'  => $products,
        ];


        return $this->data($data, 'All Products data retrieved successfully');

    }

    public function create(){

        $brands     = Brand::all();
        $platforms  = Platform::all();
        $categories = Category::all();
        $subs       = Subcategory::all();
        $features   = Features::all();

        $data = [
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
        $productData['AddedBy'] = Auth::guard('sanctum')->user()->id;
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
        $technologies = is_array($request->Technology) ? $request->Technology : [$request->Technology];
        foreach ($technologies as $Technology) {
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
        $productEvaluationData['ExpertID'] = Auth::guard('sanctum')->user()->id;
        ProductEvaluation::create($productEvaluationData);

        // Create Product FAQ
        if (!empty($faqData['Question'])) {
            // Check if 'Question' is an array or a single value
            $questions = is_array($faqData['Question']) ? $faqData['Question'] : [$faqData['Question']];

            foreach ($questions as $index => $question) {
                if (!empty($question)) {
                    $faq = new ProductFaq();
                    $faq['ProductID']    = $product->id;
                    $faq->Question       = $question;

                    // Handle associated data, making sure to handle both array and non-array cases
                    $faq->Answer         = is_array($faqData['Answer'] ?? null) ? $faqData['Answer'][$index] ?? null : $faqData['Answer'] ?? null;
                    $faq->ArabicQuestion = is_array($faqData['ArabicQuestion'] ?? null) ? $faqData['ArabicQuestion'][$index] ?? null : $faqData['ArabicQuestion'] ?? null;
                    $faq->ArabicAnswer   = is_array($faqData['ArabicAnswer'] ?? null) ? $faqData['ArabicAnswer'][$index] ?? null : $faqData['ArabicAnswer'] ?? null;

                    $faq->save();
                }
            }
        }
        return $this->success('Product Added Successfully');

    }

    public function update(UpdateProductRequest $request , Product $product, ProductDetails $details , ProductImages $images)
    {
        $productDetails = $details::where('ProductID' , $product->ID)->first();

        $productData           = $request->only('Name','ArabicName','Description','ArabicDescription','Price','Quantity','InstallationCost','SubCategoryID','BrandID','IsBundle');
        $productDetailsData    = $request->only('Title','Title2','ArabicTitle','ArabicTitle2','Video','Width','Height','Length','Color','Capacity','PowerConsumption','Weight');
        $productPlatformsData  = ensureArray($request->PlatformID);
        $productTechnologyData = ensureArray($request->Technology);
        $productFeatureData    = ensureArray($request->FeatureID);
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
        if (!empty($productPlatformsData)) {
            SyncChoices::Sync(ProductPlatforms::class, $product->ID, $productPlatformsData, 'PlatformID');
        }

        // Update ProductTechnology
        if (!empty($productTechnologyData)) {
            SyncChoices::Sync(ProductTechnology::class, $product->ID, $productTechnologyData, 'Technology');
        }

        // Update Feature
        if (!empty($productFeatureData)) {
            SyncChoices::Sync(ProductFeatures::class, $product->ID, $productFeatureData, 'FeatureID');
        }

        // Update Product Evaluation
        $productEvaluationData['ProductID'] = $product->ID;
        ProductEvaluation::where('ProductID' , $product->ID)->update($productEvaluationData);

        // Update Product FAQ
        if (!empty($faqData['Question'])) {
            // Check if 'Question' is an array or a single value
            $questions = is_array($faqData['Question']) ? $faqData['Question'] : [$faqData['Question']];
            $answers = is_array($faqData['Answer']) ? $faqData['Answer'] : [$faqData['Answer']];
            $arabicQuestions = is_array($faqData['ArabicQuestion']) ? $faqData['ArabicQuestion'] : [$faqData['ArabicQuestion']];
            $arabicAnswers = is_array($faqData['ArabicAnswer']) ? $faqData['ArabicAnswer'] : [$faqData['ArabicAnswer']];

            foreach ($questions as $index => $question) {
                if (!empty($question)) {
                    // Create or update FAQ entry
                    ProductFaq::updateOrCreate(
                        [
                            'ProductID' => $product->ID,
                            'Question' => $question, // Assuming the 'Question' field is unique for each FAQ entry
                        ],
                        [
                            'Answer' => $answers[$index] ?? null,
                            'ArabicQuestion' => $arabicQuestions[$index] ?? null,
                            'ArabicAnswer' => $arabicAnswers[$index] ?? null,
                        ]
                    );
                }
            }
        }

        return $this->success('Product Updated Successfully');

    }

    public function show(Product $product){

        $product = $product::with(['brand', 'platforms', 'subcategory.category','faqs','images' ,'technologies', 'features', 'sale', 'collections' , 'evaluations.admin' , 'productDetails'])->first();

        return $this->data(compact('product'), 'Product data retrieved successfully');

    }

    public function userShow(Product $product)
    {
        $product = $product::with(['brand', 'platforms', 'subcategory.category','faqs','images' ,'technologies', 'features', 'sale', 'collections' , 'evaluations.admin' , 'productDetails'])->first();

        $products = Product::with(['brand', 'platforms', 'subcategory.category'])->get();

        $data = [
            'Recommended-Products' => $products,
            'Product' => $product,
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
            'product'   => $this->transformImagePaths($product),
            'brands'    => $this->transformImagePaths($brands),
            'platforms' => $this->transformImagePaths($platforms),
            'categories'=> $this->transformImagePaths($categories),
            'subs'      => $this->transformImagePaths($subs),
            'features'  => $this->transformImagePaths($features),
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