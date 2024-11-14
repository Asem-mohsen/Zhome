<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    public function run()
    {
        $countries = require database_path('data/countries.php');

        foreach ($countries as $country) {
            Country::create($country);
        }
    }
}
