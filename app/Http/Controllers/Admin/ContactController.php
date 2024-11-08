<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SiteSetting;
use App\Http\Requests\Admin\UpdateContactRequest;

class ContactController extends Controller
{
    public function index()
    {
        $siteSetting = SiteSetting::with(['phones' , 'markets', 'user'])->first();

        return view('Admin.Contact.index' , compact('siteSetting'));
    }

    public function edit(SiteSetting $site)
    {
        $site->load(['phones' , 'markets', 'user']);

        $users = User::pluck('name', 'id');

        return view('Admin.Contact.edit' , compact('site', 'users'));
    }

    public function update(UpdateContactRequest $request , SiteSetting $site){

        $data = $request->except('_method', '_token');

        $site->update($data);

        return redirect()->route('Contact.index')->with('success','Site Settings Updated Successfully');
    }

}
