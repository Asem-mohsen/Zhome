<?php

namespace Database\Seeders;

use App\Models\Tool;
use App\Models\ToolOrder;
use Illuminate\Database\Seeder;

class ToolSeeder extends Seeder
{
    public function run(): void
    {
        Tool::factory(5)->create();

        ToolOrder::factory(30)->create();
    }
}
