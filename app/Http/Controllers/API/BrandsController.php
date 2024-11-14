<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AddBrandRequest;
use App\Http\Requests\Admin\UpdateBrandRequest;
use App\Http\Resources\BrandResource;
use App\Models\Brand;
use App\Traits\ApiResponse;

class BrandsController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $brands = Brand::with(['products'])->whereHas('products')->get();

        $data = [
            'brands' => BrandResource::collection($brands),
        ];

        return $this->data($data, 'Brands retrieved successfully');
    }

    public function store(AddBrandRequest $request)
    {
        $data = $request->except('image', '_token', '_method');

        $brand = Brand::create($data);

        if ($request->hasFile('image')) {
            $brand->addMediaFromRequest('image')->toMediaCollection('brand-image');
        }

        return $this->success('Brand Added Successfully');
    }

    public function edit(Brand $brand)
    {

        $brand->load('media');

        return $this->data(compact('brand'), 'Brand data for editing retrieved successfully');

    }

    public function update(UpdateBrandRequest $request, Brand $brand)
    {
        $data = $request->except('image', '_token', '_method');

        $brand->update($data);

        if ($request->hasFile('image')) {

            $brand->clearMediaCollection('brand-image');

            $brand->addMediaFromRequest('image')->toMediaCollection('brand-image');
        }

        return $this->success('Brand Updated Successfully');
    }

    public function destroy(Brand $brand)
    {

        try {

            $brand->clearMediaCollection('brand-image');

            $brand->delete();

            return $this->success('Brand Deleted Successfully');

        } catch (\Exception $e) {

            return $this->error(['delete_error' => $e->getMessage()], 'Failed to delete Brand');

        }

    }
}
