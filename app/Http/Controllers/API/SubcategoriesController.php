<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\{ AddSubcategoryRequest , UpdateSubCategoryRequest};
use App\Models\{ Category , Subcategory};
use Exception;

class SubcategoriesController extends Controller
{
    public function create(Category $category)
    {
        return successResponse($category->toArray(), 'categories for creating subcategory retrieved successfully');
    }

    public function edit(Subcategory $subcategory)
    {
        return successResponse($subcategory->toArray(), 'subcategory for editing retrieved successfully');
    }

    public function store(AddSubcategoryRequest $request, Category $category)
    {
        $data = $request->except('_method', '_token', 'image');

        try {
            $data['category_id'] = $category->id;
            $subcategory = Subcategory::create($data);

            if ($request->hasFile('image')) {
                $subcategory->addMediaFromRequest('image')->toMediaCollection('subcategory-image');
            }
            return successResponse(message: 'subcategory created successfully!');

        } catch (Exception $e) {
            return failureResponse(message: 'An error occurred while adding the subcategory');
        }

    }

    public function update(UpdateSubCategoryRequest $request, Subcategory $subcategory)
    {
        $data = $request->except('image', '_token', '_method');

        try {
            $subcategory->update($data);

            if ($request->hasFile('image')) {

                $subcategory->clearMediaCollection('subcategory-image');
    
                $subcategory->addMediaFromRequest('image')->toMediaCollection('subcategory-image');
            }

            return successResponse(message: 'subcategory updated successfully!');

        } catch (Exception $e) {
            return failureResponse(message: 'An error occurred while updating the subcategory');
        }
    }

    public function destroy(Subcategory $subcategory)
    {
        $subcategory->clearMediaCollection('subcategory-image');

        $subcategory->delete();

        return successResponse(message: 'subcategory deleted successfully!');
    }
}
