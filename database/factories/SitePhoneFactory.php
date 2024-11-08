<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\SiteSetting;

class SitePhoneFactory extends Factory
{
    public function definition() : array
    {
        return [
            'site_id' => SiteSetting::inRandomOrder()->first()->id,
            'phone' => $this->faker->unique()->phoneNumber,
        ];
    }
}
