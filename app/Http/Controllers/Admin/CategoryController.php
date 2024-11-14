<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AddCategoryReqeust;
use App\Http\Requests\Admin\UpdateCategoryRequest;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('subcategories')->get();

        return view('Admin.Category.index', compact('categories'));
    }

    public function create()
    {
        return view('Admin.Category.create');
    }

    public function store(AddCategoryReqeust $request)
    {
        $data = $request->validated();

        $data = $request->except('image', '_token', '_method');

        $category = Category::create($data);

        if ($request->hasFile('image')) {
            $category->addMediaFromRequest('image')->toMediaCollection('category-image');
        }

        toastr()->success(message: 'Category created successfully!');

        return redirect()->route('Category.index');
    }

    public function edit(Category $category)
    {
        return view('Admin.Category.edit', compact('category'));
    }

    public function show(Category $category)
    {
        $category->load('subcategories');

        return view('Admin.Category.show', compact('category'));
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $data = $request->except('image', '_token', '_method');

        $category->update($data);

        if ($request->hasFile('image')) {

            $category->clearMediaCollection('category-image');

            $category->addMediaFromRequest('image')->toMediaCollection('category-image');
        }

        toastr()->success(message: 'Category updated successfully!');

        return redirect()->route('Category.edit', $category->id);
    }

    public function destroy(Category $category)
    {
        $category->clearMediaCollection('category-image');

        $category->delete();

        toastr()->success(message: 'Category deleted successfully!');

        return redirect()->route('Category.index');
    }
}
