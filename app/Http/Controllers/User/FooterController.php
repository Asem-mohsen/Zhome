<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;

class FooterController extends Controller
{
    public function contact(){
        $contact = Contact::first();
        return view('User.layout.footer', compact('contact'));
    }
}