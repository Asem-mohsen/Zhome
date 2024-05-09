<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class UserController extends Controller
{
<<<<<<< HEAD
    public function index(){
        $Users = DB::table('user')->get();
        return view('Admin.Users.index', compact('Users'));
    }

    public function profile(User $user){
        return view('Admin.Users.profile', compact('user'));
=======
    function index(){
        return view('Admin.Users.index'); 
>>>>>>> 9063c251a6238c86a6e42429c51b13d7dbbeb693
    }
}