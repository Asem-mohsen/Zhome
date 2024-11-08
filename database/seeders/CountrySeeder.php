<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Country;

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
