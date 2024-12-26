<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\{ AddCollectionRequest , UpdateCollectionRequest};
use App\Models\{ Collection , Feature , Product };

class CollectionsController extends Controller
{
    public function index()
    {
        $collections = Collection::withCount('products')->get();

        return successResponse($collections->toArray(), 'Collection retrieved successfully');
    }

    public function create()
    {
        $products = Product::all();
        $features = Feature::all();

        $data = [
            'products ' => $products ,
            'features ' => $features ,
        ];

        return successResponse($data, 'Products retrieved successfully');
    }

    public function store(AddCollectionRequest $request)
    {
        $data = $request->except('_token', '_method', 'image', 'feature_id', 'product_id');

        $collection = Collection::create($data);

        if ($request->hasFile('image')) {
            $collection->addMediaFromRequest('image')->toMediaCollection('collection-image');
        }

        if ($request->has('product_id')) {
            $collection->products()->sync($request->input('product_id'));
        }

        if ($request->has('feature_id')) {
            $collection->features()->sync($request->input('feature_id'));
        }

        return successResponse(message:'Collection Added successfully');
    }

    public function edit(Collection $collection)
    {
        $collection->load('products', 'features');

        $products = Product::all();
        $features = Feature::all();

        $data = [
            'collection' => $collection,
            'products' => $products,
            'features' => $features,
        ];

        return successResponse($data , message:'data retrieved successfully');
    }

    public function update(UpdateCollectionRequest $request, Collection $collection)
    {
        $data = $request->except('_token', '_method', 'image', 'product_id', 'feature_id');

        $collection->update($data);

        if ($request->hasFile('image')) {

            $collection->clearMediaCollection('collection-image');

            $collection->addMediaFromRequest('image')->toMediaCollection('collection-image');
        }

        if ($request->has('product_id')) {
            $collection->products()->sync($request->input('product_id'));
        } else {
            $collection->products()->detach();
        }

        if ($request->has('feature_id')) {
            $collection->features()->sync($request->input('feature_id'));
        } else {
            $collection->features()->detach();
        }

        return successResponse(message:'Collection updated successfully');
    }

    public function destroy(Collection $collection)
    {

        try {
            $collection->products()->detach();
            $collection->features()->detach();
    
            $collection->clearMediaCollection('collection-image');
    
            $collection->delete();

            return successResponse(message:'Collection deleted successfully');

        } catch (\Exception $e) {
            return failureResponse(message:'Failed to delete Collection');
        }

    }
}
