<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use App\Http\Requests\Admin\AddCategoryReqeust;
use App\Http\Requests\Admin\UpdateCategoryRequest;
use App\Traits\ApiResponse;
use App\Http\Resources\CategoryResource;

class CategoriesController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $categories = Category::with(['subcategories', 'products'])->get();

        $data = [
            'categories' => CategoryResource::collection($categories),
        ];

        return $this->data($data, 'Categories retrieved successfully');
    }

    public function edit(Category $category)
    {
        return $this->data($category->toArray(), 'category retrieved successfully');
    }

    public function show(Category $category)
    {
        $category->load('subcategories');

        return $this->data($category->toArray(), 'category retrieved successfully');
    }

    public function update(UpdateCategoryRequest $request ,Category $category)
    {
        $data = $request->except('image', '_token','_method');
        
        $category->update($data);

        if ($request->hasFile('image')) {

            $category->clearMediaCollection('category-image');

            $category->addMediaFromRequest('image')->toMediaCollection('category-image');
        }

        return $this->success('Category Updated Successfully');
    }

    public function store(AddCategoryReqeust $request)
    {
        $data = $request->validated();

        $data = $request->except('image','_token','_method');
        
        $category = Category::create($data);

        if ($request->hasFile('image')) 
        {
            $category->addMediaFromRequest('image')->toMediaCollection('category-image');
        }

        return $this->success('Category Added Successfully');
    }

    public function destroy(Category $category){

        try {
            
            $category->clearMediaCollection('category-image');

            $category->delete();

            return $this->success('Category Deleted Successfully');

        } catch (\Exception $e) {

            return $this->error(['delete_error' => $e->getMessage()], 'Failed to delete Category');

        }

    }
}