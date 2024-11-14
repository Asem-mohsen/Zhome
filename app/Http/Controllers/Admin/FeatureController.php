<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AddFeatureRequest;
use App\Http\Requests\Admin\UpdateFeatureRequest;
use App\Models\Feature;

class FeatureController extends Controller
{
    public function index()
    {
        $features = Feature::withCount(['products', 'collections'])->get();

        return view('Admin.Features.index', compact('features'));
    }

    public function show(Feature $feature)
    {
        $feature->load(['products.translations', 'products.platforms', 'products.brand']);

        return view('Admin.Features.show', compact('feature'));
    }

    public function create()
    {
        return view('Admin.Features.create');
    }

    public function store(AddFeatureRequest $request)
    {
        $data = $request->except('_token', '_method', 'image');

        $feature = Feature::create($data);

        if ($request->hasFile('image')) {
            $feature->addMediaFromRequest('image')->toMediaCollection('feature-image');
        }

        toastr()->success(message: 'Feature created successfully!');

        return redirect()->route('Features.index');
    }

    public function edit(Feature $feature)
    {
        return view('Admin.Features.edit', compact('feature'));
    }

    public function update(UpdateFeatureRequest $request, Feature $feature)
    {
        $data = $request->except('_token', '_method', 'image');

        $feature->update($data);

        if ($request->hasFile('image')) {

            $feature->clearMediaCollection('feature-image');

            $feature->addMediaFromRequest('image')->toMediaCollection('feature-image');
        }

        toastr()->success(message: "Feature {$request->name} updated successfully!");

        return redirect()->route('Features.show', $feature->id);
    }

    public function destroy(Feature $feature)
    {

        $feature->clearMediaCollection('feature-image');

        $feature->delete();

        toastr()->success(message: 'Feature deleted successfully!');

        return redirect()->route('Features.index');
    }
}
