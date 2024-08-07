<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Services;
use App\Traits\ApiResponse;

class ServicesController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $services = Services::all();

        return $this->data($services->toArray(), 'All Services Retrived Successfully');
    }
}