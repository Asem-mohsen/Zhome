<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Subcategory;
use App\Http\Requests\Admin\AddCategoryReqeust;
use App\Http\Requests\Admin\UpdateCategoryRequest;

use App\Http\Services\Media;

class CategoryController extends Controller
{
    public function index(){
        $Categories = Category::all();
        $subCounts = [];
        foreach ($Categories as $category) {
            $subNumber = Subcategory::where('MainCategoryID', $category->ID)->count();
            $subCounts[$category->ID] = $subNumber;
        }
        return view('Admin.Category.index' , compact('Categories' , 'subCounts'));
    }

    public function create(){
        return view('Admin.Category.create');
    }

    public function edit(Category $category){
        return view('Admin.Category.edit' , compact('category'));
    }

    public function show(Category $category){
        $subCategories = Subcategory::where('MainCategoryID', $category->ID)->get();
        return view('Admin.Category.show' , compact('category' , 'subCategories'));
    }
    public function update(UpdateCategoryRequest $request ,Category $category){

        $data = $request->except('image', '_token','_method');
        if($request->hasFile('image')){
            $newImageName = Media::upload($request->file('image') , 'Admin\dist\img\web\Categories');
            $data['MainImage'] = $newImageName;
            Media::delete(public_path("Admin\dist\img\web\Categories\\{$category->MainImage}"));
        }
        Category::where('ID' , $category->ID)->update($data);
        return redirect()->route('Category.edit' , $category->ID)->with('success', 'Category Updated Successfully');
    }

    public function store(AddCategoryReqeust $request){

        $newImageName = Media::upload($request->file('image'), 'Admin\dist\img\web\Categories');

        $data = $request->except('image','_token','_method');
        $data['MainImage'] = $newImageName;

        Category::create($data);

        return redirect()->route('Category.index')->with('success', 'Category Added Successfully');
    }

    public function destroy(Category $category){

        Media::delete(public_path("Admin\dist\img\web\Categories\\{$category->MainImage}"));
        Category::where('ID', $category->ID)->delete();

        return redirect()->route('Category.index')->with('success', 'Category Deleted Successfully');
    }
}
