<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderInstallation;

class OrderSeeder extends Seeder
{

    public function run(): void
    {
        Order::factory(10)->create();

        OrderInstallation::factory(15)->create();
    }
}
