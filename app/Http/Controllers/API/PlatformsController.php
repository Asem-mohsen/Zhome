<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Platform;
use App\Models\PlatformFAQ;
use App\Http\Requests\Admin\AddPlatformRequest;
use App\Http\Requests\Admin\UpdatePlatfromRequest;
use App\Http\Services\Media;
use App\Traits\ApiResponse;
use App\Traits\HandleImgPath;

class PlatformsController extends Controller
{
    use ApiResponse , HandleImgPath;

    public function index(){

        $Platforms = Platform::all();

        // Modify the Platforms data to include the full image path
        $transformedBrands = $this->transformImagePaths(
            $Platforms,
            [
                'Logo' => ['path' => 'Admin/dist/img/web/Platforms/'],
                'CoverImage' => ['path' => 'Admin/dist/img/web/Platforms/CoverImgs/'],
            ]
        );


        return $this->data($Platforms->toArray(), 'platforms retrieved successfully');

    }

    public function userIndex(){

        $platformsIds = Platform::distinct()->pluck('ID');

        $platforms    = Platform::with('products.brand' , 'Faqs')
                    ->whereIn('ID', $platformsIds)
                    ->get();

        // Modify the Platforms data to include the full image path
        $transformedPlatforms = $this->transformImagePaths(
            $platforms,
            [
                'Logo' => ['path' => 'Admin/dist/img/web/Platforms/'],
                'CoverImage' => ['path' => 'Admin/dist/img/web/Platforms/CoverImgs/'],
            ]
        );
        $transformedPlatforms->transform(function ($platform) {
            $platform->products = $this->transformImagePaths($platform->products, [
                'MainImage' => ['path' => 'Admin/dist/img/web/Products/MainImage/'],
            ]);
            return $platform;
        });

        return $this->data($platforms->toArray(), 'platforms retrieved successfully');

    }

    public function store(AddPlatformRequest $request){

        $newImageName = Media::upload($request->file('image'), 'Admin\dist\img\web\Platforms');

        $platformData = $request->except('image','_token','_method','Question','Answer' , 'Name');
        $platformData['Logo'] = $newImageName;
        $platformData['Platform']  = $request->Name;
        $platform = Platform::create($platformData);

        $FAQdata = $request->only('Question','Answer');


        $FAQdata['PlatformID']= $platform->id;

        PlatformFAQ::create($FAQdata);

        return $this->success('Platform Added Successfully');

    }

    public function edit(Platform $platform, PlatformFAQ $FAQ)
    {

        $FAQData = PlatformFAQ::where('PlatformID' , $platform->ID)->first();

        $data = [
            'FAQData' => $FAQData,
            'platform' => $platform,
        ];

        return $this->data($data, 'platform data for editing retrieved successfully');

    }

    public function update(UpdatePlatfromRequest $request , Platform $platform)
    {

        $data = $request->except('image', '_token','_method','Question','Answer','Name');

        if($request->hasFile('image')){

            $newImageName = Media::upload($request->file('image') , 'Admin\dist\img\web\Platforms');

            $data['Logo'] = $newImageName; // hashed name

            Media::delete(public_path("Admin\dist\img\web\Platforms\\{$platform->Logo}"));
        }
        $data['Platform']  = $request->Name;
        $editedPlatform = Platform::where('ID' , $platform->ID)->update($data);

        $FAQdata = $request->only('Question','Answer');

        PlatformFAQ::where('PlatformID' , $platform->ID)->update($FAQdata);

        return $this->success('Platform UpdatedSuccessfully');

    }

    public function destroy(Platform $platform , PlatformFAQ $FAQ){

        try {

            $FAQ::where('PlatformID', $platform->ID)->delete();

            Media::delete(public_path("Admin\dist\img\web\Platforms\\{$platform->Logo}"));

            $platform::where('ID', $platform->ID)->delete();

            return $this->success('Platform Deleted Successfully');

        } catch (\Exception $e) {

            return $this->error(['delete_error' => $e->getMessage()], 'Failed to delete Platform');

        }

    }
}