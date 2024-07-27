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

class PlatformController extends Controller
{
    use ApiResponse;

    public function index(){

        $Platforms = Platform::all();

        return $this->data($Platforms->toArray(), 'platforms retrieved successfully');

    }

    public function userIndex(){

        $platformsIds = Platform::distinct()->pluck('ID');

        $platforms    = Platform::with('products' , 'Faqs')
                    ->whereIn('ID', $platformsIds)
                    ->get();

        return $this->data($platforms->toArray(), 'platforms retrieved successfully');

    }

    public function store(AddPlatformRequest $request){

        $newImageName = Media::upload($request->file('image'), 'Admin\dist\img\web\Platforms');

        $platformData = $request->except('image','_token','_method','Question','Answer');
        
        $platformData['Logo'] = $newImageName;

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
        
        $data = $request->except('image', '_token','_method','Question','Answer');
        
        if($request->hasFile('image')){

            $newImageName = Media::upload($request->file('image') , 'Admin\dist\img\web\Platforms');
            
            $data['Logo'] = $newImageName; // hashed name
            
            Media::delete(public_path("Admin\dist\img\web\Platforms\\{$platform->Logo}"));
        }
        
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
