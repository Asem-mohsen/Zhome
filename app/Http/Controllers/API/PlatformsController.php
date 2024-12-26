<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\{ AddPlatformRequest , UpdatePlatfromRequest};
use App\Http\Resources\PlatformResource;
use App\Models\{ Platform , PlatformFAQ} ;

class PlatformsController extends Controller
{
    public function index()
    {
        $platforms = Platform::with(['products', 'faqs', 'media'])->whereHas('products')->get();

        $data = [
            'platforms' => PlatformResource::collection($platforms),
        ];

        return successResponse($data, 'platforms retrieved successfully');
    }

    public function store(AddPlatformRequest $request)
    {
        $data = $request->except('image', '_token', '_method', 'question', 'answer');

        $platform = Platform::create($data);

        if ($request->hasFile('image')) {
            $platform->addMediaFromRequest('image')->toMediaCollection('platform-image');
        }

        $faqData = $request->only('question', 'answer');

        if ($request->filled('question')) {
            foreach ($request->question as $index => $question) {
                if (! empty($question) && ! empty($request->answer[$index])) {
                    PlatformFAQ::create([
                        'platform_id' => $platform->id,
                        'question' => $question,
                        'answer' => $request->answer[$index],
                    ]);
                }
            }
        }

        return successResponse(message: 'Platform Added Successfully');
    }

    public function edit(Platform $platform)
    {
        $platform->load('faqs');

        return successResponse($platform->toArray(), 'platform data for editing retrieved successfully');
    }

    public function update(UpdatePlatfromRequest $request, Platform $platform)
    {
        $data = $request->except('image', '_token', '_method', 'question', 'answer');

        $platform->update($data);

        if ($request->hasFile('image')) {

            $platform->clearMediaCollection('platform-image');

            $platform->addMediaFromRequest('image')->toMediaCollection('platform-image');
        }

        $faqData = $request->only('question', 'answer');

        $platform->faqs()->update($faqData);

        return successResponse(message: 'Platform Updated Successfully');

    }

    public function destroy(Platform $platform)
    {
        try {
            $platform->clearMediaCollection('platform-image');

            $platform->delete();

            return successResponse(message: 'Platform Deleted Successfully');

        } catch (\Exception $e) {

            return failureResponse(message: 'Failed to delete Platform');

        }

    }
}
