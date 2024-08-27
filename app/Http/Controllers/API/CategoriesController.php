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
use App\Http\Services\Media;
use App\Traits\HandleImgPath;

class CategoriesController extends Controller
{
    use ApiResponse , HandleImgPath ;

    public function index()
    {

        $Categories = Category::all();
        $subCounts = [];
        foreach ($Categories as $category) {
            $subNumber = Subcategory::where('MainCategoryID', $category->ID)->count();
            $subCounts["Category with ID: " . $category->ID] = $subNumber;
        }
        $Categories = $this->transformImagePaths($Categories);
        $data = [
            'Categories' => $Categories,
            'Number of sub for each category' => $subCounts
        ];

        return $this->data($data, 'Categories retrieved successfully');

    }

    public function userIndex()
    {

        $categories = Category::whereHas('subcategories.products')
        ->with([
            'products' => function ($query) {
                $query->with(['brand', 'platforms']);
            },
            'subcategories' => function ($query) {
                $query->whereHas('products');
            }
        ])
        ->get();

        $categories = $this->transformImagePaths($categories);
        return $this->data($categories->toArray(), 'Categories retrieved successfully');

    }

    public function edit(Category $category){

        return $this->data($category->toArray(), 'category retrieved successfully');

    }

    public function show(Category $category){

        $subCategories = Subcategory::where('MainCategoryID', $category->ID)->get();

        $data = [
            'category'      => $category,
            'subCategories' => $subCategories
        ];

        return $this->data($data, 'category retrieved successfully');

    }

    public function update(UpdateCategoryRequest $request ,Category $category){

        $data = $request->except('image', '_token','_method');

        if($request->hasFile('image')){

            $newImageName = Media::upload($request->file('image') , 'Admin\dist\img\web\Categories');

            $data['MainImage'] = $newImageName;

            Media::delete(public_path("Admin\dist\img\web\Categories\\{$category->MainImage}"));

        }

        Category::where('ID' , $category->ID)->update($data);

        return $this->success('Category Updated Successfully');

    }

    public function store(AddCategoryReqeust $request){

        $newImageName = Media::upload($request->file('image'), 'Admin\dist\img\web\Categories');

        $data = $request->except('image','_token','_method');

        $data['MainImage'] = $newImageName;

        Category::create($data);

        return $this->success('Category Added Successfully');

    }

    public function destroy(Category $category){

        try {
            Media::delete(public_path("Admin\dist\img\web\Categories\\{$category->MainImage}"));
            Category::where('ID', $category->ID)->delete();

            return $this->success('Category Deleted Successfully');

        } catch (\Exception $e) {

            return $this->error(['delete_error' => $e->getMessage()], 'Failed to delete Category');

        }

    }
}