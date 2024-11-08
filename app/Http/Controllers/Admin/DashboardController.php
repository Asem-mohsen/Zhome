<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $authenticatedAdmin = Auth::guard('web')->user();
        
        return view('Admin.index' , compact('authenticatedAdmin'));
    }
}