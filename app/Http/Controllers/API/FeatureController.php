<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AddFeatureRequest;
use App\Http\Requests\Admin\UpdateFeatureRequest;
use App\Models\Feature;
use App\Traits\ApiResponse;

class FeatureController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $features = Feature::withCount(['products', 'collections'])->get();

        return $this->data(compact('features'), 'features retrieved successfully');
    }

    public function show(Feature $feature)
    {
        $feature->load(['products']);

        return $this->data(compact('feature'), 'data retrieved successfully');
    }

    public function store(AddFeatureRequest $request)
    {
        $data = $request->except('_token', '_method', 'image');

        $feature = Feature::create($data);

        if ($request->hasFile('image')) {
            $feature->addMediaFromRequest('image')->toMediaCollection('feature-image');
        }

        return $this->success('Feature Added Successfully');
    }

    public function edit(Feature $feature)
    {
        return $this->data($feature->toArray(), 'feature data retrieved successfully');
    }

    public function update(UpdateFeatureRequest $request, Feature $feature)
    {
        $data = $request->except('_token', '_method', 'image');

        $feature->update($data);

        if ($request->hasFile('image')) {

            $feature->clearMediaCollection('feature-image');

            $feature->addMediaFromRequest('image')->toMediaCollection('feature-image');
        }

        return $this->success('Feature Updated Successfully');
    }

    public function destroy(Feature $feature)
    {
        $feature->clearMediaCollection('feature-image');

        $feature->delete();

        return $this->success('Feature Deleted Successfully');
    }
}
