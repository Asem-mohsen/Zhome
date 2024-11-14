<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AddSubcategoryRequest;
use App\Http\Requests\Admin\UpdateSubCategoryRequest;
use App\Http\Services\Media;
use App\Models\Category;
use App\Models\Subcategory;
use App\Traits\ApiResponse;

class SubcategoriesController extends Controller
{
    use ApiResponse;

    public function create(Category $category)
    {

        return $this->data($category->toArray(), 'categories for creating subcategory retrieved successfully');

    }

    public function edit(Subcategory $subcategory)
    {

        return $this->data($subcategory->toArray(), 'subcategory for editing retrieved successfully');

    }

    public function store(AddSubcategoryRequest $request, Category $category)
    {

        $newImageName = Media::upload($request->file('image'), 'Admin\dist\img\web\Categories\SubCategory');

        $data = $request->except('_method', '_token', 'image');

        $data['MainCategoryID'] = $category->ID;

        $data['image'] = $newImageName;

        Subcategory::create($data);

        return $this->success('Subcategory Added Successfully');

    }

    public function update(UpdateSubCategoryRequest $request, Subcategory $subcategory)
    {

        $data = $request->except('image', '_token', '_method');

        if ($request->hasFile('image')) {

            $newImageName = Media::upload($request->file('image'), 'Admin\dist\img\web\Categories\SubCategory');

            $data['image'] = $newImageName;

            $oldImagePath = public_path("Admin/dist/img/web/Categories/SubCategory/{$subcategory->image}");

            if (is_file($oldImagePath)) {

                Media::delete($oldImagePath);

            }

        }

        Subcategory::where('ID', $subcategory->ID)->update($data);

        return $this->success('Subcategory Updated Successfully');
    }

    public function destroy(Subcategory $subcategory)
    {

        try {

            Media::delete(public_path("Admin\dist\img\web\Categories\SubCategory\\{$subcategory->image}"));

            Subcategory::where('ID', $subcategory->ID)->delete();

            return $this->success('Subcategory Deleted Successfully');

        } catch (\Exception $e) {

            return $this->error(['delete_error' => $e->getMessage()], 'Failed to delete Subcategory');

        }

    }
}
