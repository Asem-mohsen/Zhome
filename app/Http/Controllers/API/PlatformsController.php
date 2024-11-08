<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Platform;
use App\Models\PlatformFAQ;
use App\Http\Requests\Admin\AddPlatformRequest;
use App\Http\Requests\Admin\UpdatePlatfromRequest;
use App\Traits\ApiResponse;
use App\Http\Resources\PlatformResource;

class PlatformsController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $platforms = Platform::with(['products', 'faqs', 'media'])->whereHas('products')->get();

        $data = [
            'platforms' => PlatformResource::collection($platforms),
        ];

        return $this->data($data, 'platforms retrieved successfully');
    }

    public function store(AddPlatformRequest $request)
    {
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

        return $this->success('Platform Added Successfully');
    }

    public function edit(Platform $platform)
    {
        $platform->load('faqs');

        return $this->data($platform->toArray(), 'platform data for editing retrieved successfully');
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

        return $this->success('Platform UpdatedSuccessfully');
    }

    public function destroy(Platform $platform){

        try {

            $platform->clearMediaCollection('platform-image');

            $platform->delete();

            return $this->success('Platform Deleted Successfully');

        } catch (\Exception $e) {

            return $this->error(['delete_error' => $e->getMessage()], 'Failed to delete Platform');

        }

    }
}