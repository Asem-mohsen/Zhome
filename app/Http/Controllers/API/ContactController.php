<?php

namespace App\Http\Controllers\API;

use App\Events\ContactUsEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateContactRequest;
use App\Models\SiteSetting;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $site = SiteSetting::with(['phones', 'markets'])->first();

        return $this->data(compact('site'), 'Site data retrieved successfully');
    }

    public function edit(SiteSetting $site)
    {
        return $this->data($site->toArray(), 'Site data retrieved successfully');
    }

    public function update(UpdateContactRequest $request, SiteSetting $site)
    {

        $data = $request->except('_method', '_token');

        $site->update($data);

        return $this->success('Site Settings data Updated successfully');

    }

    public function contact()
    {
        $site = SiteSetting::first();

        return $this->data($site->toArray(), 'Site retrieved successfully');

    }

    public function sendContactUsEmail(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Extract validated data
        $userName = $validatedData['name'];
        $userEmail = $validatedData['email'];
        $subject = $validatedData['subject'];
        $messageContent = $validatedData['message'];

        // Dispatch the event
        event(new ContactUsEvent($userName, $userEmail, $subject, $messageContent));

        return response()->json(['message' => 'Your message has been sent successfully.']);
    }
}
