<?php

namespace Database\Seeders;

use App\Models\SiteMarket;
use App\Models\SitePhone;
use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $siteSetting = SiteSetting::factory()->create();

        SitePhone::factory()->count(2)->create(['site_id' => $siteSetting->id]);

        SiteMarket::factory()->count(2)->create(['site_id' => $siteSetting->id]);

    }
}
