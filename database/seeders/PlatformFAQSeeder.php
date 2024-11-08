<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Platform;
use App\Models\PlatformFAQ;

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
