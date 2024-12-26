<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\{ AddCategoryReqeust , UpdateCategoryRequest};
use App\Http\Resources\CategoryResource;
use App\Models\Category;

class CategoriesController extends Controller
{
    public function index()
    {
        $categories = Category::with(['subcategories', 'products'])->get();

        $data = [
            'categories' => CategoryResource::collection($categories),
        ];

        return successResponse($data ,'Categories retrieved successfully');
    }

    public function edit(Category $category)
    {
        return successResponse($category->toArray() ,'category retrieved successfully');
    }

    public function show(Category $category)
    {
        $category->load('subcategories');

        return successResponse($category->toArray() ,'category retrieved successfully');
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $data = $request->except('image', '_token', '_method');

        $category->update($data);

        if ($request->hasFile('image')) {

            $category->clearMediaCollection('category-image');

            $category->addMediaFromRequest('image')->toMediaCollection('category-image');
        }

        return successResponse(message:'Category Updated Successfully');
    }

    public function store(AddCategoryReqeust $request)
    {
        $data = $request->validated();

        $data = $request->except('image', '_token', '_method');

        $category = Category::create($data);

        if ($request->hasFile('image')) {
            $category->addMediaFromRequest('image')->toMediaCollection('category-image');
        }

        return successResponse(message:'Category Added Successfully');
    }

    public function destroy(Category $category)
    {
        try {

            $category->clearMediaCollection('category-image');

            $category->delete();

            return successResponse(message:'Category Deleted Successfully');

        } catch (\Exception $e) {

            return failureResponse(message:'Failed to delete Category');

        }

    }
}
