<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Collections;
use App\Models\ProductCollections;
use App\Http\Requests\Admin\AddCollectionRequest;
use App\Http\Requests\Admin\UpdateCollectionRequest;
use Illuminate\Http\Request;
use App\Http\Services\Media;
use App\Models\CollectionFeatures;
use App\Http\Services\SyncChoices;
use App\Traits\ApiResponse;

class CollectionsController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $collections = Collection::withCount('products')->get();

        return $this->data($collections->toArray(), 'Collection retrieved successfully');
    }

    public function create()
    {
        $products = Product::all();

        return $this->data($products->toArray(), 'Products retrieved successfully');
    }

    public function store(AddCollectionRequest $request)
    {
        $newImageName = Media::upload($request->file('image'), 'Admin\dist\img\web\Collections');

        $data = $request->except('_token', '_method', 'image', 'ProductID', 'Feature' ,'Feature-Image' , 'EndDate', 'Feature-Description');
        $data['Image'] = $newImageName;
        $collection = Collections::create($data);

        // Create Collection products
        $productCollectionData = $request->only('ProductID');
        $productCollectionData['CollectionID'] = $collection->id;
        foreach ($request->ProductID as $productId) {
            // Check if the ProductID exists in the product table
            if (Product::where('ID', $productId)->exists()) {
                $productCollectionData['ProductID'] = $productId;
                ProductCollections::create($productCollectionData);
            } else {
                // Handle the case where the ProductID doesn't exist
                return $this->error(["error"=>"Product with ID {$productId} does not exist."], 422);
            }
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

        return $this->success('Collection Added successfully');
    }

    public function edit(Collections $collection)
    {
        $collection = $collection::with('products' , 'features')->where('ID' , $collection->ID )->first();
        $products = Product::all();

        $data = [
            'collection' => $collection,
            'All products' => $products,
        ];

        return $this->data($data, 'data retrieved successfully');

    }

    public function update(UpdateCollectionRequest $request , Collections $collection)
    {
        $data = $request->except('_token','_method','image', 'ProductID', 'features');

        if($request->hasFile('image')){
            $newImageName = Media::upload($request->file('image'), 'Admin\dist\img\web\Collections');
            $data['Image'] = $newImageName;
            $oldImagePath = public_path("Admin/dist/img/web/Collections/{$collection->Image}");
            if (is_file($oldImagePath)) {
                Media::delete($oldImagePath);
            }
        }
        Collections::where('ID' , $collection->ID)->update($data);

        // update Collection products
        if($request->ProductID){
            SyncChoices::Sync(ProductCollections::class , $collection->ID , $request->ProductID , 'ProductID' ,'CollectionID');
        }
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

        return $this->success('Collection updated successfully');
    }


    public function destroy(Collections $collection){

        try {

            ProductCollections::where('CollectionID', $collection->ID)->delete();
            $collectionFeatures = CollectionFeatures::where('CollectionID', $collection->ID)->get();
            foreach ($collectionFeatures as $feature) {

                Media::delete(public_path("Admin/dist/img/web/Collections/Features/{$feature->Image}"));

                $feature->delete();

            }
            $collection::where('ID' , $collection->ID)->delete();


            Media::delete(public_path("Admin\dist\img\web\Collections\\{$collection->Image}"));

            return $this->success('Collection Deleted Successfully');

        } catch (\Exception $e) {

            return $this->error(['delete_error' => $e->getMessage()], 'Failed to delete Collection');

        }

    }
}
