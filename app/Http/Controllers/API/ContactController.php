<?php

namespace App\Http\Controllers\API;

use App\Events\ContactUsEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\Contact\{ SendContactUsEmailRequest , UpdateContactRequest};
use App\Models\SiteSetting;

class ContactController extends Controller
{

    public function index()
    {
        $site = SiteSetting::with(['phones', 'markets'])->first();

        return successResponse(compact('site') , message:'Site data retrieved successfully');
    }

    public function edit(SiteSetting $site)
    {
        return successResponse($site->toArray(), message:'Site data retrieved successfully');
    }

    public function update(UpdateContactRequest $request, SiteSetting $site)
    {
        $data = $request->except('_method', '_token', 'phones', 'markets');

        $site->update($data);

        if ($request->has('phones')) {
            $site->phones()->delete();
            foreach ($request->input('phones') as $phoneData) {
                $site->phones()->create($phoneData);
            }
        }
    
        if ($request->has('markets')) {
            $site->markets()->delete();
            foreach ($request->input('markets') as $marketData) {
                $site->markets()->create($marketData); 
            }
        }

        return successResponse(message:'Site Settings data Updated successfully');
    }

    public function contact()
    {
        $site = SiteSetting::first();

        return successResponse($site->toArray(), 'Site retrieved successfully');
    }

    public function sendContactUsEmail(SendContactUsEmailRequest $request)
    {
        $validated = $request->validated();

        // Extract validated data
        $userName = $validated['name'];
        $userEmail = $validated['email'];
        $subject = $validated['subject'];
        $messageContent = $validated['message'];

        // Dispatch the event
        event(new ContactUsEvent($userName, $userEmail, $subject, $messageContent));

        return successResponse(message: 'Your message has been sent successfully.');
    }
}
