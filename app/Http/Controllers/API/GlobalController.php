<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\{ Country, City};

class GlobalController extends Controller
{
    public function countries()
    {
        $countries = Country::whereIn('country_code' , ['EG'])->get();

        return successResponse(compact('countries') ,'countries retrieved successfully');
    }

    public function cities($countryId)
    {
        $cities = City::select('id' , 'name', 'country_id')->where('country_id' , $countryId)->get();

        return successResponse(compact('cities') ,'cities retrieved successfully');
    }
}
