<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserContactController extends Controller
{
    public function contact()
    {
        view('User.Contact.index');
    }
}
