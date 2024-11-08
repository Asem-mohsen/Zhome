<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SiteSetting;
use App\Models\SitePhone;
use App\Models\SiteMarket;

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
