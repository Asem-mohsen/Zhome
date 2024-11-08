<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Platform;
use App\Models\PlatformFAQ;
use App\Http\Requests\Admin\AddPlatformRequest;
use App\Http\Requests\Admin\UpdatePlatfromRequest;

class PlatformController extends Controller
{
    public function index()
    {
        $platforms = Platform::with('media')->withCount('products')->get();

        return view('Admin.Platforms.index' , compact('platforms'));
    }

    public function create()
    {
        return view('Admin.Platforms.create');
    }

    public function store(AddPlatformRequest $request){

        $data = $request->except('image','_token','_method','question','answer');

        $platform = Platform::create($data);

        if ($request->hasFile('image')) 
        {
            $platform->addMediaFromRequest('image')->toMediaCollection('platform-image');
        }
        
        $faqData = $request->only('question','answer');

        if ($request->filled('question')) {
            foreach ($request->question as $index => $question) {
                if (!empty($question) && !empty($request->answer[$index])) {
                    PlatformFAQ::create([
                        'platform_id' => $platform->id,
                        'question' => $question,
                        'answer' => $request->answer[$index],
                    ]);
                }
            }
        }

        return redirect()->route('Platform.index')->with('success', 'Platform Added Successfully');
    }

    public function edit(Platform $platform){

        $platform->load('faqs');

        return view('Admin.Platforms.edit' ,compact('platform'));
    }

    public function update(UpdatePlatfromRequest $request , Platform $platform)
    {
        $data = $request->except('image', '_token','_method','question','answer');

        $platform->update($data);

        if ($request->hasFile('image')) {

            $platform->clearMediaCollection('platform-image');

            $platform->addMediaFromRequest('image')->toMediaCollection('platform-image');
        }

        $faqData = $request->only('question','answer');

        $platform->faqs()->update($faqData);

        return redirect()->route('Platform.edit', $platform->id)->with('success' , 'Platform Updated Successfully');

    }

    public function destroy(Platform $platform){

        $platform->clearMediaCollection('platform-image');

        $platform->delete();

        return redirect()->route('Platform.index')->with('success', 'Platform Deleted Successfully');

    }
}
