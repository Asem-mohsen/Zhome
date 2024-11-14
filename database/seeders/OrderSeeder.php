<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderInstallation;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        Order::factory(10)->create();

        OrderInstallation::factory(15)->create();
    }
}
