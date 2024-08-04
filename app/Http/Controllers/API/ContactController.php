<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
use App\Http\Requests\Admin\UpdateContactRequest;
use App\Http\Requests\User\AddNewContactRequest;
use App\Traits\ApiResponse;

class ContactController extends Controller
{
    use ApiResponse;

    public function index()
    {
        
        $contact = Contact::all()->first();
        
        return $this->data($contact->toArray(), 'contact retrieved successfully');

    }

    public function edit(Contact $contact)
    {
        
        $contact = Contact::all()->first();
        
        return $this->data($contact->toArray(), 'contact retrieved successfully');

    }

    public function update(UpdateContactRequest $request ,Contact $contact)
    {

        $data = $request->except('_method', '_token');

        $contact::where('ID', $contact->ID)->update($data);
        
        return $this->success('Contact Updated successfully');

    }

    public function contact()
    {
        $contact = Contact::all()->first();

        return $this->data($contact->toArray(), 'contact retrieved successfully');

    }

}