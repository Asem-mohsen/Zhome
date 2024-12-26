<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AddBrandRequest;
use App\Http\Requests\Admin\UpdateBrandRequest;
use App\Http\Resources\BrandResource;
use App\Models\Brand;
use Illuminate\Support\Facades\Log;

class BrandsController extends Controller
{
    public function index()
    {
        $brands = Brand::with(['products'])->whereHas('products')->get();

        $data = [
            'brands' => BrandResource::collection($brands),
        ];

        return successResponse($data, 'Brands retrieved successfully');
    }

    public function store(AddBrandRequest $request)
    {
        $data = $request->except('image', '_token', '_method');

        $brand = Brand::create($data);

        if ($request->hasFile('image')) {
            $brand->addMediaFromRequest('image')->toMediaCollection('brand-image');
        }

        return successResponse(message:'Brands Added successfully');
    }

    public function edit(Brand $brand)
    {

        $brand->load('media');

        return successResponse(compact('brand') , 'Brand data for editing retrieved successfully');
    }

    public function update(UpdateBrandRequest $request, Brand $brand)
    {
        $data = $request->except('image', '_token', '_method');

        $brand->update($data);

        if ($request->hasFile('image')) {

            $brand->clearMediaCollection('brand-image');

            $brand->addMediaFromRequest('image')->toMediaCollection('brand-image');
        }

        return successResponse(compact('brand') , 'Brand Updated Successfully');
    }

    public function destroy(Brand $brand)
    {

        try {
            $brand->clearMediaCollection('brand-image');

            $brand->delete();

            return successResponse(message:'Brand Deleted Successfully');

        } catch (\Exception $e) {

            Log::error('error deleting brand : ' . $e->getMessage() );

            return failureResponse('Failed to delete Brand');

        }

    }
}
