<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(){
        $Users = User::all();
        return view('Admin.Users.index', compact('Users'));
    }

    public function profile(User $user){
        return view('Admin.Users.profile', compact('user'));
    }
}