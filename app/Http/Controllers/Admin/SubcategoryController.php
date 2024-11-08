<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Subcategory;
use App\Http\Requests\Admin\AddSubcategoryRequest;
use App\Http\Requests\Admin\UpdateSubCategoryRequest;

class SubcategoryController extends Controller
{
    public function create(Category $category)
    {
        return view('Admin.Category.Sub.create' , compact('category'));
    }

    public function edit(Subcategory $subcategory)
    {
        return view('Admin.Category.Sub.edit' , compact('subcategory'));
    }

    public function store(AddSubcategoryRequest $request , Category $category)
    {
        $data = $request->except('_method','_token','image');

        $data['category_id'] = $category->id;

        $subcategory = Subcategory::create($data);

        if ($request->hasFile('image')) 
        {
            $subcategory->addMediaFromRequest('image')->toMediaCollection('subcategory-image');
        }

        return redirect()->route('Category.show' ,$category->id )->with('success', 'Subcategory Added Successfully');
    }

    public function update(UpdateSubCategoryRequest $request , Subcategory $subcategory)
    {
        $data = $request->except('image', '_token','_method');

        $subcategory->update($data);

        if ($request->hasFile('image')) {

            $subcategory->clearMediaCollection('subcategory-image');

            $subcategory->addMediaFromRequest('image')->toMediaCollection('subcategory-image');
        }
        
        return redirect()->back()->with('success', 'Subcategory Updated Successfully');
    }

    public function destroy(Subcategory $subcategory){
        
        $subcategory->clearMediaCollection('subcategory-image');

        $subcategory->delete();

        return redirect()->back()->with('success', 'Subcategory Deleted Successfully');
    }
}