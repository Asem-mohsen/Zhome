<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Platform;
use Illuminate\Http\Request;

class NavbarController extends Controller
{
    public function data(){
        $categories = Category::with('subcategories')->get();
        $brands     = Brand::all();
        $platforms  =  Platform::all();

        return view('User.layout.Nav', compact('categories','platforms','brands'));
    }
    
}
