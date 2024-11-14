<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AddPlatformRequest;
use App\Http\Requests\Admin\UpdatePlatfromRequest;
use App\Models\Platform;
use App\Models\PlatformFAQ;

class PlatformController extends Controller
{
    public function index()
    {
        $platforms = Platform::with('media')->withCount('products')->get();

        return view('Admin.Platforms.index', compact('platforms'));
    }

    public function create()
    {
        return view('Admin.Platforms.create');
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

        toastr()->success(message: 'Platform created successfully!');

        return redirect()->route('Platform.index');
    }

    public function edit(Platform $platform)
    {

        $platform->load('faqs');

        return view('Admin.Platforms.edit', compact('platform'));
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

        toastr()->success(message: 'Platform updated successfully!');

        return redirect()->route('Platform.edit', $platform->id);
    }

    public function destroy(Platform $platform)
    {
        $platform->clearMediaCollection('platform-image');

        $platform->delete();

        toastr()->success(message: 'Platform deleted successfully!');

        return redirect()->route('Platform.index');

    }
}
