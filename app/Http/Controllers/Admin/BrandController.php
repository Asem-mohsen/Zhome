<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\AddBrandRequest;
use App\Http\Requests\Admin\UpdateBrandRequest;
use App\Http\Services\Media;

class BrandController extends Controller
{
    public function index(){
        $Brands = Brand::all();
        return view('Admin.Brands.index' , compact('Brands'));
    }

    public function create(){
        return view('Admin.Brands.create');
    }

    public function userIndex()
    {
        $brandIds = Brand::distinct()->pluck('ID');
        $brands   = Brand::with('products')
                    ->whereIn('ID', $brandIds)
                    ->get();

        return view('User.Brands.index' , compact('brands'));
    }

    public function store(AddBrandRequest $request){
        $newImageName = Media::upload($request->file('image'), 'Admin\dist\img\web\Brands');
        $data = $request->except('image','_token','_method');
        $data['Logo'] = $newImageName;
        Brand::create($data);

        return redirect()->route('Brands.index')->with('success', 'Brand Added Successfully');
    }

    public function edit(Brand $brand){
        return view('Admin.Brands.edit' ,compact('brand'));
    }

    public function update(UpdateBrandRequest $request , Brand $brand){
        $data = $request->except('image', '_token','_method');
        if($request->hasFile('image')){
            $newImageName = Media::upload($request->file('image') , 'Admin\dist\img\web\Brands');
            $data['Logo'] = $newImageName;
            Media::delete(public_path("Admin\dist\img\web\Brands\\{$brand->Logo}"));
        }
        Brand::where('ID' , $brand->ID)->update($data);

        return redirect()->route('Brands.edit', $brand->ID)->with('success' , 'Brand Updated Successfully');

    }

    public function destroy(Brand $brand){

        Media::delete(public_path("Admin\dist\img\web\Brands\\{$brand->Logo}"));
        $brand::where('ID', $brand->ID)->delete();
        return redirect()->route('Brands.index')->with('success', 'Brand Deleted Successfully');

    }
}
