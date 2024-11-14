<?php

namespace App\Http\Controllers\API;

use App\Enums\CommentStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\{ AddProductRequest , UpdateProductRequest};
use App\Models\{ Brand ,Category , Feature , Platform ,Product ,Subcategory ,Technology};
use App\Services\ProductService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductsController extends Controller
{
    use ApiResponse;

    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index() // all products for admin
    {
        $products = Product::with(['translations', 'brand', 'platforms', 'subcategory.category', 'sale'])->get();

        return $this->data($data = ['products' => $products], 'All Products data retrieved successfully');
    }

    public function productCards(Request $request) // a products card api for only the prodicts
    {
        $products = Product::with(['translations', 'brand', 'platforms'])->get();

        return $this->data($data = ['products' => $products], 'Products data retrieved successfully');
    }

    public function create()
    {
        $data = [
            'brands' => Brand::all(),
            'platforms' => Platform::all(),
            'categories' => Category::all(),
            'features' => Feature::all(),
            'subs' => Subcategory::all(),
        ];

        return $this->data($data, 'All Products data retrieved successfully');
    }

    public function getSubcategories($categoryId) //for creation
    {
        $subcategories = SubCategory::where('category_id', $categoryId)->get();

        return response()->json($subcategories);
    }

    public function store(AddProductRequest $request)
    {
        DB::transaction(function () use ($request) {
            $product = Product::create([
                'quantity' => $request->input('quantity'),
                'price' => $request->input('price'),
                'installation_cost' => $request->input('installation_cost'),
                'is_bundle' => $request->boolean('is_bundle'),
                'subcategory_id' => $request->input('subcategory_id'),
                'brand_id' => $request->input('brand_id'),
                'video_url' => $request->input('video_url'),
                'added_by' => Auth::guard('sanctum')->user()->id,
                'updated_by' => Auth::guard('sanctum')->user()->id,
            ]);

            // Handle media files using Spatie Media Library
            if ($request->hasFile('cover_image')) {
                $product->addMediaFromRequest('cover_image')->toMediaCollection('cover_image');
            }

            if ($request->hasFile('image')) {
                $product->addMediaFromRequest('image')->toMediaCollection('product_featured_image');
            }

            if ($request->hasFile('other_images')) {
                foreach ($request->file('other_images') as $otherImage) {
                    $product->addMedia($otherImage)->toMediaCollection('other_product_images');
                }
            }

            // Handling relationships and translations
            $product->platforms()->attach($request->input('platform_id'));
            $product->technologies()->attach($request->input('technology_id'));
            $product->features()->attach($request->input('feature_id'));

            $keys = $request->input('dimension_keys');
            $values = $request->input('dimension_values');

            foreach ($keys as $index => $key) {
                if ($key && isset($values[$index])) {
                    $product->dimensions()->create([
                        'dimension_key' => $key,
                        'value' => $values[$index],
                    ]);
                }
            }

            // Add color records
            foreach ($request->input('color') as $color) {
                $product->colors()->create(['color' => $color]);
            }

            // FAQ Translations
            if ($request->has('question') && is_array($request->input('question'))) {
                $questions = $request->input('question');
                $answers = $request->input('answer');
                $arQuestions = $request->input('ar_question');
                $arAnswers = $request->input('ar_answer');
            
                foreach ($questions as $index => $question) {
                    if (isset($answers[$index], $arQuestions[$index], $arAnswers[$index])) {
                        $product->faqs()->create([
                            'question' => $question,
                            'answer' => $answers[$index],
                            'ar_question' => $arQuestions[$index],
                            'ar_answer' => $arAnswers[$index],
                        ]);
                    }
                }
            }

            // Product reviews Translation
            $product->reviews()->create([
                'user_id' => $product->added_by,
                'comment' => $request->input('comment'),
                'ar_comment' => $request->input('ar_comment'),
                'status' => CommentStatusEnum::Published->value,
            ]);

            // Product Description Translation
            $product->translations()->createMany([
                'name' => $request->input('name'),
                'ar_name' => $request->input('ar_name'),
                'description' => $request->input('description'),
                'additional_description' => $request->input('additional_description'),
                'ar_description' => $request->input('ar_description'),
                'ar_additional_description' => $request->input('ar_additional_description'),
                'title' => $request->input('title'),
                'second_title' => $request->input('second_title'),
                'ar_title' => $request->input('ar_title'),
                'ar_second_title' => $request->input('ar_second_title'),
            ]);

        });

        return $this->success('Product Added Successfully');
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        DB::transaction(function () use ($request, $product) {
            // Update main product fields
            $product->update([
                'quantity' => $request->input('quantity'),
                'price' => $request->input('price'),
                'installation_cost' => $request->input('installation_cost'),
                'is_bundle' => $request->boolean('is_bundle'),
                'category_id' => $request->input('category_id'),
                'subcategory_id' => $request->input('subcategory_id'),
                'brand_id' => $request->input('brand_id'),
                'video_url' => $request->input('video_url'),
                'updated_by' => Auth::guard('sanctum')->user()->id,
            ]);

            // Update media files
            if ($request->hasFile('cover_image')) {
                $product->clearMediaCollection('cover_image');
                $product->addMediaFromRequest('cover_image')->toMediaCollection('cover_image');
            }

            if ($request->hasFile('image')) {
                $product->clearMediaCollection('product_featured_image');
                $product->addMediaFromRequest('image')->toMediaCollection('product_featured_image');
            }

            if ($request->hasFile('other_images')) {
                $product->clearMediaCollection('other_product_images');
                foreach ($request->file('other_images') as $otherImage) {
                    $product->addMedia($otherImage)->toMediaCollection('other_product_images');
                }
            }

            // Update relationships
            $product->platforms()->sync($request->input('platform_id', []));
            $product->technologies()->sync($request->input('technology_id', []));
            $product->features()->sync($request->input('feature_id', []));

            $keys = $request->input('dimension_keys');
            $values = $request->input('dimension_values');

            $product->dimensions()->delete();

            foreach ($keys as $index => $key) {
                if ($key && isset($values[$index])) {
                    $product->dimensions()->create([
                        'dimension_key' => $key,
                        'value' => $values[$index],
                    ]);
                }
            }

            // Update colors
            $product->colors()->delete();
            foreach ($request->input('color', []) as $color) {
                $product->colors()->create(['color' => $color]);
            }

            // Update FAQs with translations
            $product->faqs()->delete();
            if ($request->has('question') && is_array($request->input('question'))) {
                $questions = $request->input('question');
                $answers = $request->input('answer');
                $arQuestions = $request->input('ar_question');
                $arAnswers = $request->input('ar_answer');
            
                foreach ($questions as $index => $question) {
                    // Ensure each element exists at this index before using it
                    if (isset($answers[$index], $arQuestions[$index], $arAnswers[$index])) {
                        $product->faqs()->create([
                            'question' => $question,
                            'answer' => $answers[$index],
                            'ar_question' => $arQuestions[$index],
                            'ar_answer' => $arAnswers[$index],
                        ]);
                    }
                }
            }

            // Update reviews translations
            $product->reviews()->delete();
            $product->reviews()->create(
                [
                    'user_id' => $product->added_by,
                    'comment' => $request->input('comment'),
                    'ar_comment' => $request->input('ar_comment'),
                    'status' => CommentStatusEnum::Published->value,
                ],
            );

            // Update description translations
            $product->translations()->updateOrCreate(
                ['product_id' => $product->id],
                [
                    'name' => $request->input('name'),
                    'ar_name' => $request->input('ar_name'),
                    'description' => $request->input('description'),
                    'additional_description' => $request->input('additional_description'),
                    'ar_description' => $request->input('ar_description'),
                    'ar_additional_description' => $request->input('ar_additional_description'),
                    'title' => $request->input('title'),
                    'second_title' => $request->input('second_title'),
                    'ar_title' => $request->input('ar_title'),
                    'ar_second_title' => $request->input('ar_second_title'),
                ]
            );
        });

        return $this->success('Product Updated Successfully');
    }

    public function show(Product $product)
    {
        $product->load([
            'translations',
            'brand',
            'platforms',
            'subcategory.category',
            'faqs.translations',
            'technologies',
            'features',
            'sale',
            'collections',
            'reviews' => function ($query) {
                $query->latest()->limit(1);
            },
            'colors',
            'dimensions',
        ]);

        $products = Product::with(['brand', 'platforms', 'translations'])->get();

        $data = [
            'recommended_products' => $products,
            'product' => $product,
            'other_images' => $product->other_images,
        ];

        return $this->data($data, 'Product data retrieved successfully');
    }

    public function edit(Product $product)
    {

        $product->load(['translations', 'brand', 'platforms', 'subcategory.category', 'faqs', 'technologies', 'features', 'sale', 'collections', 'reviews', 'colors', 'dimensions']);

        $data = [
            'product' => $product,
            'brands' => Brand::all(),
            'platforms' => Platform::all(),
            'categories' => Category::all(),
            'subs' => Subcategory::all(),
            'features' => Feature::all(),
        ];

        return $this->data($data, 'Product data for editing retrieved successfully');

    }

    public function destroy(Product $product)
    {
        try {

            DB::transaction(function () use ($product) {

                $product->clearMediaCollection('cover_image');
                $product->clearMediaCollection('product_featured_image');
                $product->clearMediaCollection('other_product_images');

                $product->translations()->delete();
                $product->features()->detach();
                $product->platforms()->detach();
                $product->technologies()->detach();
                $product->dimensions()->delete();
                $product->faqs()->delete();
                $product->reviews()->delete();
                $product->colors()->delete();

                $product->delete();

            });

            return $this->success('Product Deleted Successfully');

        } catch (\Exception $e) {

            return $this->error(['delete_error' => $e->getMessage()], 'Failed to delete Product');

        }

    }
}
