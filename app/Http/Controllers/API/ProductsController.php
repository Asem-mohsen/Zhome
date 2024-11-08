<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\{User, Category , Subcategory , Product ,Platform ,Brand ,Feature, ProductFaqTranslation, ProductReview , ProductDimension};
use App\Http\Requests\Admin\AddProductRequest;
use App\Http\Requests\Admin\UpdateProductRequest;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\DB;
use App\Enums\CommentStatusEnum;

class ProductsController extends Controller
{
    use ApiResponse;

    public function index() // all products for admin
    {
        $products = Product::with(['translations', 'brand', 'platforms', 'subcategory.category' , 'sale'])->get();

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
            'brands'     => Brand::all(),
            'platforms'  => Platform::all(),
            'categories' => ategory::all(),
            'features'   => Feature::all(),
            'subs'       => Subcategory::all(),
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
                'quantity'              => $request->input('quantity'),
                'price'                 => $request->input('price'),
                'installation_cost'     => $request->input('installation_cost'),
                'is_bundle'             => $request->boolean('is_bundle'),
                'subcategory_id'        => $request->input('subcategory_id'),
                'brand_id'              => $request->input('brand_id'),
                'video_url'             => $request->input('video_url'),
                'added_by'              => Auth::guard('sanctum')->user()->id,
                'updated_by'            => Auth::guard('sanctum')->user()->id,
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

            $dimensionsData = [
                'product_id'        => $product->id,
                'width'             => $request->input('width'),
                'height'            => $request->input('height'),
                'length'            => $request->input('length'),
                'capacity'          => $request->input('capacity'),
                'noise_level'       => $request->input('noise_level'),
                'weight'            => $request->input('weight'),
                'power_consumption' => $request->input('power_consumption'),
            ];

            $hasDimensionData = collect($dimensionsData)->except('product_id')->filter()->isNotEmpty();

            if ($hasDimensionData) {
                $product->dimensions()->create($dimensionsData);
            }

            // Add color records
            foreach ($request->input('color') as $color) {
                $product->colors()->create(['color' => $color]);
            }

            // FAQ Translations
            if ($request->input('question') && $request->input('answer')) {

                $faq = $product->faqs()->create();

                $faq->translations()->createMany([
                    [
                        'question' => $request->input('question'),
                        'answer'   => $request->input('answer'),
                        'locale'   => 'en',
                    ],
                    [
                        'question' => $request->input('ar_question'),
                        'answer'   => $request->input('ar_answer'),
                        'locale'   => 'ar',
                    ],
                ]);
            }

            // Product reviews Translation
            $product->reviews()->create([
                'user_id' => $product->added_by,
                'comment' => $request->input('comment'),
                'ar_comment' => $request->input('ar_comment'),
                'status' => CommentStatusEnum::Published->value
            ]);

            // Product Description Translation
            $product->translations()->createMany([
                [
                    'name'                  => $request->input('name'),
                    'description'           => $request->input('description'),
                    'additional_description'=> $request->input('additional_description'),
                    'title'                 => $request->input('title'),
                    'second_title'          => $request->input('second_title'),
                    'locale'                => 'en',
                ],
                [
                    'name'                  => $request->input('ar_name'),
                    'description'           => $request->input('ar_description'),
                    'additional_description'=> $request->input('ar_additional_description'),
                    'title'                 => $request->input('ar_title'),
                    'second_title'          => $request->input('ar_second_title'),
                    'locale'                => 'ar',
                ],
            ]);

        });

        return $this->success('Product Added Successfully');
    }

    public function update(UpdateProductRequest $request , Product $product)
    {
        DB::transaction(function () use ($request, $product) {
            // Update main product fields
            $product->update([
                'quantity'              => $request->input('quantity'),
                'price'                 => $request->input('price'),
                'installation_cost'     => $request->input('installation_cost'),
                'is_bundle'             => $request->boolean('is_bundle'),
                'category_id'           => $request->input('category_id'),
                'subcategory_id'        => $request->input('subcategory_id'),
                'brand_id'              => $request->input('brand_id'),
                'video_url'             => $request->input('video_url'),
                'updated_by'            => Auth::guard('sanctum')->user()->id,
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

            // Update or create dimensions
            $product->dimensions()->updateOrCreate(
                ['product_id' => $product->id],
                [
                    'width'             => $request->input('width'),
                    'height'            => $request->input('height'),
                    'length'            => $request->input('length'),
                    'capacity'          => $request->input('capacity'),
                    'noise_level'       => $request->input('noise_level'),
                    'weight'            => $request->input('weight'),
                    'power_consumption' => $request->input('power_consumption'),
                ]
            );

            // Update colors
            $product->colors()->delete();
            foreach ($request->input('color', []) as $color) {
                $product->colors()->create(['color' => $color]);
            }

            // Update FAQs with translations
            $product->faqs()->delete();
            if ($request->input('question') && $request->input('answer')) {
                $faq = $product->faqs()->create();

                $faq->translations()->createMany([
                    [
                        'question' => $request->input('question'),
                        'answer'   => $request->input('answer'),
                        'locale'   => 'en',
                    ],
                    [
                        'question' => $request->input('ar_question'),
                        'answer'   => $request->input('ar_answer'),
                        'locale'   => 'ar',
                    ],
                ]);
            }

            // Update reviews translations
            $product->reviews()->delete();
            $product->reviews()->create(
                [
                    'user_id' => $product->added_by,
                    'comment' => $request->input('comment'),
                    'ar_comment' => $request->input('ar_comment'),
                    'status' => CommentStatusEnum::Published->value
                ],
            );

            // Update description translations
            $product->translations()->delete();
            $product->translations()->createMany([
                [
                    'name'                  => $request->input('name'),
                    'description'           => $request->input('description'),
                    'additional_description'=> $request->input('additional_description'),
                    'title'                 => $request->input('title'),
                    'second_title'          => $request->input('second_title'),
                    'locale'                => 'en',
                ],
                [
                    'name'                  => $request->input('ar_name'),
                    'description'           => $request->input('ar_description'),
                    'additional_description'=> $request->input('ar_additional_description'),
                    'title'                 => $request->input('ar_title'),
                    'second_title'          => $request->input('ar_second_title'),
                    'locale'                => 'ar',
                ],
            ]);
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
            'dimensions'
        ]);

        $products = Product::with(['brand', 'platforms' ,'translations'])->get();

        $data = [
            'recommended_products' => $products,
            'product' => $product,
            'other_images' => $product->other_images,
        ];

        return $this->data($data, 'Product data retrieved successfully');
    }

    public function edit(Product $product)
    {

        $product->load(['translations' , 'brand', 'platforms', 'subcategory.category', 'faqs', 'technologies', 'features', 'sale', 'collections', 'reviews', 'colors', 'dimensions']);

        $data = [
            'product'   => $product,
            'brands'    => Brand::all(),
            'platforms' => Platform::all(),
            'categories'=> Category::all(),
            'subs'      => Subcategory::all(),
            'features'  => Feature::all(),
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
