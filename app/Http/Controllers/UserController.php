<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class UserController extends Controller
{
    public function index(){
        $Users = DB::table('user')->get();
        return view('Admin.Users.index', compact('Users'));
    }

    public function profile(User $user){
        return view('Admin.Users.profile', compact('user'));
    }
}