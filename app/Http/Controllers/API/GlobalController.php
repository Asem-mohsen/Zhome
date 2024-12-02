<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\{ Country, City};
use App\Traits\ApiResponse;

class GlobalController extends Controller
{
    use ApiResponse;

    public function countries()
    {
        $countries = Country::whereIn('country_code' , ['EG'])->get();

        return $this->data(compact('countries') , 'countries retrieved successfully');
    }

    public function cities($countryId)
    {
        $cities = City::select('id' , 'name', 'country_id')->where('country_id' , $countryId)->get();

        return $this->data(compact('cities') , 'cities retrieved successfully');
    }
}
