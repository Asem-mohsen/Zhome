<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subscribers;


class SubscribersController extends Controller
{
    public function index(){

        $subscribers = Subscribers::all();
        return view('Admin.Subscribers.index' , compact('subscribers'));
        
    }
}
