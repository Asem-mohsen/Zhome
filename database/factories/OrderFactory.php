<?php

namespace Database\Factories;

use App\Enums\OrderStatusEnum;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class OrderFactory extends Factory
{
    public function definition(): array
    {
        $quantity = $this->faker->numberBetween(1, 5);
        $price = $this->faker->randomFloat(2, 5, 100);

        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'product_id' => Product::inRandomOrder()->first()->id,
            'quantity' => $quantity,
            'is_on_sale' => $this->faker->boolean,
            'price' => $price,
            'total_amount' => $price * $quantity,
            'transaction_id' => Str::uuid(),
            'status' => $this->faker->randomElement(OrderStatusEnum::values()),
        ];
    }
}
