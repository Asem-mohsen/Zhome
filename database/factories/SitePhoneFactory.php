<?php

namespace Database\Factories;

use App\Models\SiteSetting;
use Illuminate\Database\Eloquent\Factories\Factory;

class SitePhoneFactory extends Factory
{
    public function definition(): array
    {
        return [
            'site_id' => SiteSetting::inRandomOrder()->first()->id,
            'phone' => $this->faker->unique()->phoneNumber,
        ];
    }
}
