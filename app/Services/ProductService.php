<?php

namespace App\Services;

use App\Enums\CommentStatusEnum;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Exception;

class ProductService
{
    public function getAllProducts()
    {
        return Product::with(['translations', 'brand', 'platforms', 'subcategory.category'])->get();
    }

    public function storeProduct(Request $request)
    {
        DB::transaction(function () use ($request) {
            $product = Product::create($this->getProductData($request));

            $this->handleMedia($product, $request);
            $this->attachRelations($product, $request);
            $this->storeDimensions($product, $request);
            $this->storeColors($product, $request);
            $this->storeFaqs($product, $request);
            $this->storeReviews($product, $request);
            $this->storeTranslations($product, $request);
        });
    }

    public function updateProduct(Request $request, Product $product)
    {
        DB::transaction(function () use ($request, $product) {
            $product->update($this->getProductData($request));

            $this->handleMedia($product, $request);
            $this->syncRelations($product, $request);
            $this->storeDimensions($product, $request);
            $this->storeColors($product, $request);
            $this->storeFaqs($product, $request);
            $this->storeReviews($product, $request);
            $this->updateTranslations($product, $request);
        });
    }

    public function deleteProduct(Product $product)
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
    }

    protected function getProductData(Request $request)
    {
        return [
            'quantity' => $request->input('quantity'),
            'price' => $request->input('price'),
            'installation_cost' => $request->input('installation_cost'),
            'is_bundle' => $request->boolean('is_bundle'),
            'subcategory_id' => $request->input('subcategory_id'),
            'brand_id' => $request->input('brand_id'),
            'video_url' => $request->input('video_url'),
            'added_by' => Auth::id(),
            'updated_by' => Auth::id(),
        ];
    }

    protected function handleMedia(Product $product, Request $request)
    {
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
    }

    protected function attachRelations(Product $product, Request $request)
    {
        $product->platforms()->attach($request->input('platform_id', []));
        $product->technologies()->attach($request->input('technology_id', []));
        $product->features()->attach($request->input('feature_id', []));
    }

    protected function syncRelations(Product $product, Request $request)
    {
        $product->platforms()->sync($request->input('platform_id', []));
        $product->technologies()->sync($request->input('technology_id', []));
        $product->features()->sync($request->input('feature_id', []));
    }

    protected function storeDimensions(Product $product, Request $request)
    {
        $product->dimensions()->delete();
        $keys = $request->input('dimension_keys', []);
        $values = $request->input('dimension_values', []);

        foreach ($keys as $index => $key) {
            if ($key && isset($values[$index])) {
                $product->dimensions()->create(['dimension_key' => $key, 'value' => $values[$index]]);
            }
        }
    }

    protected function storeColors(Product $product, Request $request)
    {
        $product->colors()->delete();
        foreach ($request->input('color', []) as $color) {
            $product->colors()->create(['color' => $color]);
        }
    }

    protected function storeFaqs(Product $product, Request $request)
    {
        $product->faqs()->delete();
        $questions = $request->input('question', []);
        $answers = $request->input('answer', []);
        $arQuestions = $request->input('ar_question', []);
        $arAnswers = $request->input('ar_answer', []);

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

    protected function storeReviews(Product $product, Request $request)
    {
        $product->reviews()->delete();
        $product->reviews()->create([
            'user_id' => Auth::id(),
            'comment' => $request->input('comment'),
            'ar_comment' => $request->input('ar_comment'),
            'status' => CommentStatusEnum::Published->value,
        ]);
    }

    protected function storeTranslations(Product $product, Request $request)
    {
        $product->translations()->create([
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
    }

    protected function updateTranslations(Product $product, Request $request)
    {
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
    }
}
