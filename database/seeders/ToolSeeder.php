<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tool;
use App\Models\ToolOrder;

class ToolSeeder extends Seeder
{

    public function run(): void
    {
        Tool::factory(5)->create();

        ToolOrder::factory(30)->create();
    }
}
