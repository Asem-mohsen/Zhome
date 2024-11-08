<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Promotion;

class PromotionFactory extends Factory
{
    protected $model = Promotion::class;

    public function definition(): array
    {
        return [
            'code' => strtoupper($this->faker->unique()->lexify('PROMO??')),
            'discount_amount' => $this->faker->randomFloat(2, 5, 50),
            'status' => 'active',
            'valid_from' => $this->faker->date(),
            'valid_until' => $this->faker->dateTimeBetween('+1 month', '+6 months'),
        ];
    }
}
