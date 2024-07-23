<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\ApiResponse;

class DashboardController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $authenticatedAdmin = Auth::guard('admin')->user();
        
        return $this->data($authenticatedAdmin->toArray(), 'contact retrieved successfully');

    }
}