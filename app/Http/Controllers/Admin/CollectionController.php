<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Collection;
use App\Http\Requests\Admin\AddCollectionRequest;
use App\Http\Requests\Admin\UpdateCollectionRequest;
use Illuminate\Http\Request;
use App\Http\Services\Media;
use App\Models\CollectionFeature;
use App\Http\Services\SyncChoices;

class CollectionController extends Controller
{
    public function index()
    {
        $collections = Collection::withCount('products')->get();

        return view('Admin.Collections.index' , compact('collections'));
    }

    public function create()
    {
        $products = Product::all();

        return view('Admin.Collections.create' , compact('products'));
    }

    public function store(AddCollectionRequest $request)
    {
        $data = $request->except('_token', '_method', 'image', 'ProductID', 'features');

        $collection = Collection::create($data);

        if($request->hasFile()){

        }
        // Create Collection products
        $productCollectionData = $request->only('ProductID');
        $productCollectionData['CollectionID'] = $collection->id;
        foreach ($request->ProductID as $productId) {
            $productCollectionData['ProductID'] = $productId;
            ProductCollections::create($productCollectionData);
        }

        $features = $request->input('features', []);
        foreach ($features as $feature) {
            $featureImageName = Media::upload($feature->file('Feature-Image'), 'Admin\dist\img\web\Collections\Features');
            CollectionFeatures::create([
                'CollectionID' => $collection->id,
                'Feature' => $feature['Feature'],
                'Image' => $featureImageName,
                'Description' => $feature['Feature-Description'],
                'EndDate' => $feature['EndDate'],
            ]);
        }

        return redirect()->route('Collections.index')->with('success','Collection Added Successfully');
    }

    public function edit(Collection $collection)
    {
        $collection->load('products' , 'features');

        $products = Product::all();

        return view('Admin.Collections.edit' , compact('collection' , 'products'));
    }

    public function update(UpdateCollectionRequest $request , Collection $collection)
    {
        $data = $request->except('_token','_method','image', 'product_id', 'features');

        $collection->update($data);

        // update Collection products
        SyncChoices::Sync(ProductCollections::class , $collection->ID , $request->ProductID , 'ProductID' ,'CollectionID');

        // update Features products
        $features = $request->input('features', []);
        $existingFeatures = $collection->features->keyBy('ID');
        // Iterate through the features from the request
        foreach ($features as $index => $feature) {
            if (isset($feature['ID'])) {
                // Update existing feature
                $existingFeature = $existingFeatures->get($feature['ID']);
                if ($existingFeature) {
                    $featureImageName = $existingFeature->Image; // Keep the existing image name
                    if ($request->hasFile("features.$index.Feature-Image")) {
                        // If a new image is uploaded, delete the old one and upload the new one
                        $old_path = public_path("Admin/dist/img/web/Collections/Features/{$existingFeature->Image}");
                        if (is_file($old_path)) {
                            Media::delete($old_path);
                        }
                        $featureImageName = Media::upload($request->file("features.$index.Feature-Image"), 'Admin/dist/img/web/Collections/Features');
                    }
                    $existingFeature->update([
                        'Feature' => $feature['Feature'],
                        'Image' => $featureImageName,
                        'Description' => $feature['Feature-Description'],
                        'EndDate' => $feature['EndDate'],
                    ]);
                    // Remove the updated feature from the existing features list
                    $existingFeatures->forget($feature['ID']);
                }
            } else {
                // Create new feature
                $featureImageName = $request->hasFile("features.$index.Feature-Image")
                    ? Media::upload($request->file("features.$index.Feature-Image"), 'Admin/dist/img/web/Collections/Features')
                    : null;

                CollectionFeatures::create([
                    'CollectionID' => $collection->ID,
                    'Feature' => $feature['Feature'],
                    'Image' => $featureImageName,
                    'Description' => $feature['Feature-Description'],
                    'EndDate' => $feature['EndDate'],
                ]);
            }
        }
        // Delete features that are no longer present in the request
        foreach ($existingFeatures as $existingFeature) {
            $old_path = public_path("Admin/dist/img/web/Collections/Features/{$existingFeature->Image}");
            if (is_file($old_path)) {
                Media::delete($old_path);
            }
            $existingFeature::where('ID' ,  $existingFeature->ID)->delete();
        }

        return redirect()->route('Collections.edit', $collection->ID)->with('success',"Collection {$request->collection->Name} Updated Successfully");
    }


    public function destroy(Collection $collection)
    {
        if($collection->products()->exists()){
            return redirect()->route('Collections.index')->with('error', 'Cannot delete a Collection that is associated to a product');

        }else{
            $collectionFeatures = CollectionFeatures::where('CollectionID', $collection->id)->get();
            foreach ($collectionFeatures as $feature) {
                Media::delete(public_path("Admin/dist/img/web/Collections/Features/{$feature->Image}"));
                $feature->delete();
            }

            $collection->delete();

            return redirect()->route('Collections.index')->with('success','Collection Deleted Successfully');
        }
    }
}
