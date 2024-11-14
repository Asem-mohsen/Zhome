<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Traits\ApiResponse;

class ServicesController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $services = Service::all();

        return $this->data(compact('services'), 'All Services Retrived Successfully');
    }
}
