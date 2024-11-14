<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AddCollectionRequest;
use App\Http\Requests\Admin\UpdateCollectionRequest;
use App\Models\Collection;
use App\Models\Feature;
use App\Models\Product;



class CollectionController extends Controller
{
    public function index()
    {
        $collections = Collection::withCount('products')->get();

        return view('Admin.Collections.index', compact('collections'));
    }

    public function create()
    {
        $products = Product::all();
        $features = Feature::all();

        return view('Admin.Collections.create', compact('products', 'features'));
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

        toastr()->success(message: 'Collection added successfully!');

        return redirect()->route('Collections.index')->with('success', 'Collection Added Successfully');
    }

    public function edit(Collection $collection)
    {
        $collection->load('products', 'features');

        $products = Product::all();
        $features = Feature::all();

        $selectedFeatures = $collection->features->pluck('id')->toArray();

        return view('Admin.Collections.edit', compact('collection', 'products', 'features', 'selectedFeatures'));
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

        return redirect()->route('Collections.edit', $collection->id);
    }

    public function destroy(Collection $collection)
    {

        $collection->products()->detach();
        $collection->features()->detach();

        $collection->clearMediaCollection('collection-image');

        $collection->delete();

        toastr()->success(message: 'Collection deleted successfully!');

        return redirect()->route('Collections.index')->with('success', 'Collection Deleted Successfully');

    }
}
