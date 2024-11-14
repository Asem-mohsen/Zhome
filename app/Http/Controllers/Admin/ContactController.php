<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateContactRequest;
use App\Models\SiteSetting;
use App\Models\User;

class ContactController extends Controller
{
    public function index()
    {
        $siteSetting = SiteSetting::with(['phones', 'markets', 'user'])->first();

        return view('Admin.Contact.index', compact('siteSetting'));
    }

    public function edit(SiteSetting $site)
    {
        $site->load(['phones', 'markets', 'user']);

        $users = User::pluck('name', 'id');

        return view('Admin.Contact.edit', compact('site', 'users'));
    }

    public function update(UpdateContactRequest $request, SiteSetting $site)
    {

        $data = $request->except('_method', '_token');

        $site->update($data);

        toastr()->success(message: 'Site Settings updated successfully!');

        return redirect()->route('Contact.index');
    }
}
