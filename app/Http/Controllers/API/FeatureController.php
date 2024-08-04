<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Features;
use App\Models\ProductFeatures;
use App\Http\Requests\Admin\AddFeatureRequest;
use App\Http\Requests\Admin\UpdateFeatureRequest;
use App\Traits\ApiResponse;
use App\Http\Services\Media;


class FeatureController extends Controller
{

    use ApiResponse;

    public function index()
    {
        $features = Features::all();

        $featuresWithNumberOfProducts = [];

        foreach($features as $feature){

            $countUsed = ProductFeatures::where('FeatureID',$feature->ID)->count();

            $feature->countUsed = $countUsed;

            $featuresWithNumberOfProducts[] = $feature;

        }

        return $this->data($featuresWithNumberOfProducts->toArray(), 'features retrieved successfully');

    }

    public function show(Features $feature)
    {
        $products      = Product::with(['features' , 'brand' , 'platforms'])
                                ->whereHas('features', function ($query) use ($feature) {
                                            $query->where('FeatureID', $feature->ID);
                                        })
                                ->get();
        $countProducts = ProductFeatures::where('FeatureID',$feature->ID)->count();
        
        $data = [
            'products' => $products,
            'feature' => $feature,
            'countProducts' => $countProducts
        ];

        return $this->data($data, 'data retrieved successfully');

    }

    public function store(AddFeatureRequest $request)
    {

        $newImageName = Media::upload($request->file('image'), 'Admin\dist\img\web\Features');

        $data = $request->except('_token','_method','image');

        $data['Image'] = $newImageName;

        Features::create($data);

        return $this->success('Feature Added Successfully');
    }

    public function edit(Features $feature)
    {

        return $this->data($feature->toArray(), 'feature data retrieved successfully');

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

        return $this->success('Feature Updated Successfully');

    }

    public function destroy(Features $feature){

        try {

            if(Product::with(['features'])->exists()){

                return $this->error('Cannot delete a Feaure that is associated to a product');
    
            }else{

                $feature::where('ID' , $feature->ID)->delete();

                Media::delete(public_path("Admin\dist\img\web\Features\\{$feature->Image}"));

                return $this->success('Feature Deleted Successfully');

            }

        } catch (\Exception $e) {

            return $this->error(['delete_error' => $e->getMessage()], 'Failed to delete Feature');
        
        }

    }

}
