<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Subcategory;
use App\Http\Requests\Admin\AddSubcategoryRequest;
use App\Http\Requests\Admin\UpdateSubCategoryRequest;
use App\Http\Services\Media;

class SubcategoryController extends Controller
{
    public function create(Category $category){

        return view('Admin.Category.Sub.create' , compact('category'));
    }

    public function edit(Subcategory $subcategory){
        return view('Admin.Category.Sub.edit' , compact('subcategory'));
    }

    public function store(AddSubcategoryRequest $request , Category $category){
        
        $newImageName = Media::upload($request->file('image') , 'Admin\dist\img\web\Categories\SubCategory');
        $data = $request->except('_method','_token','image');
        
        $data['MainCategoryID'] = $category->ID;
        $data['image'] = $newImageName;
        
        Subcategory::create($data);
        return redirect()->route('Category.show' ,$category->ID )->with('success', 'Subcategory Added Successfully');
    }

    public function update(UpdateSubCategoryRequest $request , Subcategory $subcategory){

        $data = $request->except('image', '_token','_method');
        if($request->hasFile('image')){
            $newImageName = Media::upload($request->file('image') , 'Admin\dist\img\web\Categories\SubCategory');
            $data['image'] = $newImageName;
            $oldImagePath = public_path("Admin/dist/img/web/Categories/SubCategory/{$subcategory->image}");
            if (is_file($oldImagePath)) {
                Media::delete($oldImagePath);
            }
        }

        Subcategory::where('ID', $subcategory->ID)->update($data);
        
        return redirect()->back()->with('success', 'Subcategory Updated Successfully');
    }

    public function destroy(Subcategory $subcategory){
        
        Media::delete(public_path("Admin\dist\img\web\Categories\SubCategory\\{$subcategory->image}"));
        Subcategory::where('ID' , $subcategory->ID)->delete();

        return redirect()->back()->with('success', 'Subcategory Deleted Successfully');
    }
}