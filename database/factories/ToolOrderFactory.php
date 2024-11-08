<?php

namespace Database\Factories;

use App\Models\ToolOrder;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Enums\OrderStatusEnum;

class ToolOrderFactory extends Factory
{

    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'session_id' => Str::uuid(),
            'name' => $this->faker->name,
            'email' => $this->faker->safeEmail,
            'country' => $this->faker->country,
            'address' => $this->faker->address,
            'city' => $this->faker->city,
            'phone' => $this->faker->phoneNumber,
            'plan_house_document' => $this->faker->filePath(),
            'status' => $this->faker->randomElement(OrderStatusEnum::values()),
        ];
    }
}
