<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\AddBrandRequest;
use App\Http\Requests\Admin\UpdateBrandRequest;
use App\Http\Services\Media;
use App\Traits\ApiResponse;
use App\Traits\HandleImgPath;

class BrandsController extends Controller
{
    use ApiResponse , HandleImgPath ;

    public function index(){

        $Brands = Brand::all();

        $Brands = $this->transformImagePaths($Brands);

        return $this->data(compact('Brands'), 'Brands retrieved successfully');
    }

    public function userIndex()
    {
        $brands = Brand::whereHas('products')
                ->with([
                    'products' => function ($query) {
                        $query->with('platforms','brand');
                    }
                ])
                ->get();

        $brands = $this->transformImagePaths($brands);

        return $this->data(compact('brands'), 'Brands retrieved successfully');
    }

    public function store(AddBrandRequest $request){

        $newImageName = Media::upload($request->file('image'), 'Admin\dist\img\web\Brands');

        $data = $request->except('image','_token','_method');

        $data['Logo'] = $newImageName;

        Brand::create($data);

        return $this->success('Brand Added Successfully');
    }

    public function edit(Brand $brand){

        $brand = $this->transformImagePaths($brand);

        return $this->data(compact('brand'), 'Brand data for editing retrieved successfully');

    }

    public function update(UpdateBrandRequest $request , Brand $brand){

        $data = $request->except('image', '_token','_method');

        if($request->hasFile('image')){
            $newImageName = Media::upload($request->file('image') , 'Admin\dist\img\web\Brands');
            $data['Logo'] = $newImageName;
            Media::delete(public_path("Admin\dist\img\web\Brands\\{$brand->Logo}"));
        }

        Brand::where('ID' , $brand->ID)->update($data);

        return $this->success('Brand Updated Successfully');

    }

    public function destroy(Brand $brand){

        try {

            Media::delete(public_path("Admin\dist\img\web\Brands\\{$brand->Logo}"));

            $brand::where('ID', $brand->ID)->delete();

            return $this->success('Brand Deleted Successfully');

        } catch (\Exception $e) {

            return $this->error(['delete_error' => $e->getMessage()], 'Failed to delete Brand');

        }

    }
}