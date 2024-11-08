<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use App\Http\Requests\Admin\AddCategoryReqeust;
use App\Http\Requests\Admin\UpdateCategoryRequest;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('subcategories')->get();

        return view('Admin.Category.index' , compact('categories'));
    }

    public function create()
    {
        return view('Admin.Category.create');
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

        return redirect()->route('Category.index')->with('success', 'Category Added Successfully');
    }

    public function edit(Category $category)
    {
        return view('Admin.Category.edit' , compact('category'));
    }

    public function show(Category $category)
    {
        $category->load('subcategories');

        return view('Admin.Category.show' , compact('category'));
    }

    public function update(UpdateCategoryRequest $request ,Category $category)
    {
        $data = $request->except('image', '_token','_method');
        
        $category->update($data);

        if ($request->hasFile('image')) {

            $category->clearMediaCollection('category-image');

            $category->addMediaFromRequest('image')->toMediaCollection('category-image');
        }

        return redirect()->route('Category.edit' , $category->ID)->with('success', 'Category Updated Successfully');
    }

    public function destroy(Category $category)
    {
        $category->clearMediaCollection('category-image');

        $category->delete();

        return redirect()->route('Category.index')->with('success', 'Category Deleted Successfully');
    }
}