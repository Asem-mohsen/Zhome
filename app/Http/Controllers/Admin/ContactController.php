<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
use App\Http\Requests\Admin\UpdateContactRequest;
use App\Http\Requests\User\AddNewContactRequest;

class ContactController extends Controller
{
    public function index(){
        
        $contact = Contact::all()->first();
        
        return view('Admin.Contact.index' , compact('contact'));
    }

    public function edit(Contact $contact){
        
        $contact = Contact::all()->first();
        
        return view('Admin.Contact.edit' , compact('contact'));
    }

    public function update(UpdateContactRequest $request ,Contact $contact){
        $data = $request->except('_method', '_token');

        // Update Contact
        $contact::where('ID', $contact->ID)->update($data);
        
        return redirect()->route('Contact.index')->with('success','Contact Updated Successfully');
    }

    public function contact()
    {
        $contact = Contact::all()->first();
        return view('User.Contact.index', compact('contact'));
    }

}