<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\{Category , Subcategory , Product ,Platform ,Brand ,Feature, Technology};
use App\Http\Requests\Admin\AddProductRequest;
use App\Http\Requests\Admin\UpdateProductRequest;
use App\Enums\CommentStatusEnum;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['translations','brand', 'platforms', 'subcategory.category'])->get();

        return view('Admin.Products.index' , compact('products'));
    }

    public function create()
    {
        $products    = Product::all();
        $brands      = Brand::all();
        $platforms   = Platform::all();
        $categories  = Category::all();
        $features    = Feature::all();
        $technologies= Technology::all();

        return view('Admin.Products.create' , get_defined_vars());
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
                'added_by'              => Auth::guard('web')->user()->id,
                'updated_by'            => Auth::guard('web')->user()->id,
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

        return redirect()->route('Products.index')->with('success', 'Product Added Successfully');
    }

    public function update(UpdateProductRequest $request , Product $product){
        
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
                'updated_by'            => Auth::guard('web')->user()->id,
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

        return redirect()->route('Products.show' , $product->id)->with('success', 'Product Updated Successfully');
    }

    public function show(Product $product)
    {
        $product->load(['translations','brand', 'platforms', 'subcategory.category', 'faqs.translations', 'technologies', 'features', 'sale', 'collections', 'reviews', 'colors', 'dimensions']);

        return view('Admin.Products.show' , compact('product'));
    }

    public function edit(Product $product)
    {
        $product->load(['translations', 'brand', 'platforms', 'subcategory.category','faqs','technologies', 'features','sale', 'collections', 'reviews', 'colors', 'dimensions']);
       
        $brands     = Brand::all();
        $platforms  = Platform::all();
        $categories = Category::all();
        $features   = Feature::all();
        $technologies= Technology::all();

        return view('Admin.Products.edit' , get_defined_vars());
    }

    public function destroy(Product $product)
    {
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

        return redirect()->back()->with('success', 'product Deleted Successfully');
    }

    public function getSubcategories($categoryId)
    {
        $subcategories = Subcategory::where('category_id', $categoryId)->get();
        
        return response()->json($subcategories);
    }

}
