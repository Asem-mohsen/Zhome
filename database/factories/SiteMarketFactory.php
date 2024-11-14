<?php

namespace Database\Factories;

use App\Models\SiteSetting;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class SiteMarketFactory extends Factory
{
    public function definition(): array
    {
        return [
            'site_id' => SiteSetting::inRandomOrder()->first()->id,
            'market' => $this->faker->unique()->company,
            'address' => $this->faker->address,
        ];
    }
}
