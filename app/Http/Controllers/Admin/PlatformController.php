<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Platform;
use App\Models\PlatformFAQ;
use App\Http\Requests\Admin\AddPlatformRequest;
use App\Http\Requests\Admin\UpdatePlatfromRequest;
use App\Http\Services\Media;

class PlatformController extends Controller
{
    public function index(){
        $Platforms = Platform::all();
        return view('Admin.Platforms.index' , compact('Platforms'));
    }

    public function create(){
        return view('Admin.Platforms.create');
    }

    public function store(AddPlatformRequest $request){

        $newImageName = Media::upload($request->file('image'), 'Admin\dist\img\web\Platforms');

        $platformData = $request->except('image','_token','_method','Question','Answer');
        $platformData['Logo'] = $newImageName;

        $platform = Platform::create($platformData);
        $FAQdata = $request->only('Question','Answer');


        $FAQdata['PlatformID']= $platform->id;

        PlatformFAQ::create($FAQdata);

        return redirect()->route('Platform.index')->with('success', 'Platform Added Successfully');
    }

    public function edit(Platform $platform, PlatformFAQ $FAQ){
        $FAQData = PlatformFAQ::where('PlatformID' , $platform->ID)->first();
        return view('Admin.Platforms.edit' ,compact('platform' , 'FAQData'));
    }

    public function update(UpdatePlatfromRequest $request , Platform $platform){
        $data = $request->except('image', '_token','_method','Question','Answer');
        if($request->hasFile('image')){
            $newImageName = Media::upload($request->file('image') , 'Admin\dist\img\web\Platforms');
            $data['Logo'] = $newImageName; // hashed name
            Media::delete(public_path("Admin\dist\img\web\Platforms\\{$platform->Logo}"));
        }
        $editedPlatform = Platform::where('ID' , $platform->ID)->update($data);
        $FAQdata = $request->only('Question','Answer');

        PlatformFAQ::where('PlatformID' , $platform->ID)->update($FAQdata);
        return redirect()->route('Platform.edit', $platform->ID)->with('success' , 'Platform Updated Successfully');

    }

    public function destroy(Platform $platform , PlatformFAQ $FAQ){
        $FAQ::where('PlatformID', $platform->ID)->delete();
        Media::delete(public_path("Admin\dist\img\web\Platforms\\{$platform->Logo}"));
        $platform::where('ID', $platform->ID)->delete();
        return redirect()->route('Platform.index')->with('success', 'Platform Deleted Successfully');

    }
}
