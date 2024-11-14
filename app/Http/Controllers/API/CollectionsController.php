<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\{ AddCollectionRequest , UpdateCollectionRequest};
use App\Models\{ Collection , Feature , Product };
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class CollectionsController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $collections = Collection::withCount('products')->get();

        return $this->data($collections->toArray(), 'Collection retrieved successfully');
    }

    public function create()
    {
        $products = Product::all();
        $features = Feature::all();

        return $this->data($products->toArray(), 'Products retrieved successfully');
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

        return $this->success('Collection Added successfully');
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

        return $this->data($data, 'data retrieved successfully');
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

        return $this->success('Collection updated successfully');
    }

    public function destroy(Collection $collection)
    {

        try {
            $collection->products()->detach();
            $collection->features()->detach();
    
            $collection->clearMediaCollection('collection-image');
    
            $collection->delete();

            return $this->success('Collection Deleted Successfully');

        } catch (\Exception $e) {

            return $this->error(['delete_error' => $e->getMessage()], 'Failed to delete Collection');

        }

    }
}
