<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\OrderInstallation;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderInstallationFactory extends Factory
{
    protected $model = OrderInstallation::class;

    public function definition()
    {
        return [
            'order_id' => Order::inRandomOrder()->first()->id,
            'selected' => $this->faker->boolean,
            'installation_cost' => $this->faker->randomFloat(2, 20, 200),
        ];
    }
}
