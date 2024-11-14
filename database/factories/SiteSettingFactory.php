<?php

namespace Database\Factories;

use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SiteSettingFactory extends Factory
{
    protected $model = SiteSetting::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->unique()->company,
            'tagline' => $this->faker->unique()->catchPhrase,
            'owner_id' => User::inRandomOrder()->first()->id,
            'meta_title' => $this->faker->sentence,
            'meta_description' => $this->faker->paragraph,
            'google_analytics_code' => $this->faker->regexify('[A-Z0-9]{10}'),
            'facebook_pixel_code' => $this->faker->regexify('[A-Z0-9]{10}'),
            'enable_tracking' => $this->faker->boolean,
            'enable_redirecting' => $this->faker->boolean,
        ];
    }
}
