<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Feature;
use App\Models\ProductFeatures;
use App\Http\Requests\Admin\AddFeatureRequest;
use App\Http\Requests\Admin\UpdateFeatureRequest;

use App\Http\Services\Media;


class FeatureController extends Controller
{
    public function index()
    {
        $features = Feature::withCount(['products' , 'collections'])->get();

        return view('Admin.Features.index' , compact('features'));
    }

    public function show(Feature $feature)
    {
        $feature->load(['products']);

        return view('Admin.Features.show' , compact('feature'));
    }

    public function create()
    {
        return view('Admin.Features.create');
    }

    public function store(AddFeatureRequest $request)
    {
        $data = $request->except('_token','_method','image');

        $feature = Feature::create($data);

        if ($request->hasFile('image')) {
            $feature->addMediaFromRequest('image')->toMediaCollection('feature-image');
        }

        return redirect()->route('Features.index')->with('success','Feature Added Successfully');
    }

    public function edit(Feature $feature)
    {
        return view('Admin.Features.edit' , compact('feature'));
    }

    public function update(UpdateFeatureRequest $request , Feature $feature)
    {
        $data = $request->except('_token','_method','image');

        $feature->update($data);

        if ($request->hasFile('image')) {

            $feature->clearMediaCollection('feature-image');

            $feature->addMediaFromRequest('image')->toMediaCollection('feature-image');
        }

        return redirect()->route('Features.show', $feature->id)->with('success',"Feature {$request->name} Updated Successfully");
    }

    public function destroy(Feature $feature){

        $feature->clearMediaCollection('feature-image');

        $feature->delete();
        
        return redirect()->route('Features.index')->with('success','Feature Deleted Successfully');
    }
}
