<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AddBrandRequest;
use App\Http\Requests\Admin\UpdateBrandRequest;
use App\Models\Brand;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::with('media')->withCount('products')->get();

        return view('Admin.Brands.index', compact('brands'));
    }

    public function create()
    {
        return view('Admin.Brands.create');
    }

    public function store(AddBrandRequest $request)
    {
        $data = $request->except('image', '_token', '_method');

        $brand = Brand::create($data);

        if ($request->hasFile('image')) {
            $brand->addMediaFromRequest('image')->toMediaCollection('brand-image');
        }

        toastr()->success(message: 'Brand created successfully!');

        return redirect()->route('Brands.index')->with('success', 'Brand Added Successfully');
    }

    public function edit(Brand $brand)
    {
        $brand->load('media');

        return view('Admin.Brands.edit', compact('brand'));
    }

    public function update(UpdateBrandRequest $request, Brand $brand)
    {
        $data = $request->except('image', '_token', '_method');

        $brand->update($data);

        if ($request->hasFile('image')) {

            $brand->clearMediaCollection('brand-image');

            $brand->addMediaFromRequest('image')->toMediaCollection('brand-image');
        }

        toastr()->success('Data has been saved successfully!');

        return redirect()->route('Brands.edit', $brand->id);

    }

    public function destroy(Brand $brand)
    {
        $brand->clearMediaCollection('brand-image');

        $brand->delete();

        toastr()->success('Brand deleted successfully!');

        return redirect()->route('Brands.index');
    }
}
