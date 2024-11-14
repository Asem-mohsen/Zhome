<?php

namespace Database\Factories;

use App\Enums\CommentStatusEnum;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductReviewFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'comment' => $this->faker->paragraph,
            'ar_comment' => $this->faker->paragraph,
            'status' => CommentStatusEnum::values()[array_rand(CommentStatusEnum::values())],
        ];
    }
}
