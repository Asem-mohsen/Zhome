<?php

namespace Database\Seeders;

use App\Models\Platform;
use App\Models\PlatformFAQ;
use Illuminate\Database\Seeder;

class PlatformFAQSeeder extends Seeder
{
    public function run(): void
    {
        $platforms = Platform::all();

        foreach ($platforms as $platform) {
            PlatformFAQ::factory()->count(2)->create(['platform_id' => $platform->id]);
        }
    }
}
