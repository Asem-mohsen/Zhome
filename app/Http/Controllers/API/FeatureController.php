<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\{ AddFeatureRequest , UpdateFeatureRequest};
use App\Models\Feature;
class FeatureController extends Controller
{

    public function index()
    {
        $features = Feature::withCount(['products', 'collections'])->get();

        return successResponse(compact('features'), 'features retrieved successfully');
    }

    public function show(Feature $feature)
    {
        $feature->load(['products']);

        return successResponse(compact('feature'), 'data retrieved successfully');
    }

    public function store(AddFeatureRequest $request)
    {
        $data = $request->except('_token', '_method', 'image');

        $feature = Feature::create($data);

        if ($request->hasFile('image')) {
            $feature->addMediaFromRequest('image')->toMediaCollection('feature-image');
        }

        return successResponse(message: 'Feature Added Successfully');
    }

    public function edit(Feature $feature)
    {
        return successResponse($feature->toArray() , message: 'Feature Added Successfully');
    }

    public function update(UpdateFeatureRequest $request, Feature $feature)
    {
        $data = $request->except('_token', '_method', 'image');

        $feature->update($data);

        if ($request->hasFile('image')) {

            $feature->clearMediaCollection('feature-image');

            $feature->addMediaFromRequest('image')->toMediaCollection('feature-image');
        }

        return successResponse(message: 'Feature Updated Successfully');
    }

    public function destroy(Feature $feature)
    {
        $feature->clearMediaCollection('feature-image');

        $feature->delete();

        return successResponse(message: 'Feature Deleted Successfully');
    }
}
