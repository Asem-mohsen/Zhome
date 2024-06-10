<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Features;
use App\Models\ProductFeatures;
use App\Http\Requests\Admin\AddFeatureRequest;
use App\Http\Requests\Admin\UpdateFeatureRequest;

use App\Http\Services\Media;


class FeatureController extends Controller
{
    public function index()
    {
        $features = Features::all();
        $featuresWithNumberOfProducts = [];
        foreach($features as $feature){
            $countUsed = ProductFeatures::where('FeatureID',$feature->ID)->count();
            $feature->countUsed = $countUsed;
            $featuresWithNumberOfProducts[] = $feature;
        }
        return view('Admin.Features.index' , compact('featuresWithNumberOfProducts'));
    }

    public function show(Features $feature)
    {
        $products      = Product::with(['features' , 'brand' , 'platforms'])
                                ->whereHas('features', function ($query) use ($feature) {
                                            $query->where('FeatureID', $feature->ID);
                                        })
                                ->get();
        $countProducts = ProductFeatures::where('FeatureID',$feature->ID)->count();
        return view('Admin.Features.show' , compact('products' , 'feature' , 'countProducts'));
    }

    public function create()
    {
        return view('Admin.Features.create');
    }

    public function store(AddFeatureRequest $request)
    {
        $newImageName = Media::upload($request->file('image'), 'Admin\dist\img\web\Features');

        $data = $request->except('_token','_method','image');
        $data['Image'] = $newImageName;
        Features::create($data);
        return redirect()->route('Features.index')->with('success','Feature Added Successfully');
    }

    public function edit(Features $feature)
    {
        return view('Admin.Features.edit' , compact('feature'));
    }

    public function update(UpdateFeatureRequest $request , Features $feature)
    {
        $data = $request->except('_token','_method','image');

        if($request->hasFile('image')){
            $newImageName = Media::upload($request->file('image'), 'Admin\dist\img\web\Features');
            $data['Image'] = $newImageName;
            $oldImagePath = public_path("Admin/dist/img/web/Features/{$feature->Image}");
            if (is_file($oldImagePath)) {
                Media::delete($oldImagePath);
            }
        }

        Features::where('ID' , $feature->ID)->update($data);
        return redirect()->route('Features.show', $feature->ID)->with('success',"Feature {$request->Feature} Updated Successfully");
    }

    public function destroy(Features $feature){

        if(Product::with(['features'])->exists()){
            return redirect()->route('Features.index')->with('error', 'Cannot delete a Feaure that is associated to a product');

        }else{
            $feature::where('ID' , $feature->ID)->delete();
            Media::delete(public_path("Admin\dist\img\web\Features\\{$feature->Image}"));
            return redirect()->route('Features.index')->with('success','Feature Deleted Successfully');
        }
    }
}
