<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\CommentStatusEnum;
use App\Models\User;

class ProductReviewFactory extends Factory
{

    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'comment' => $this->faker->paragraph,
            'ar_comment' => $this->faker->paragraph,
            'status' => CommentStatusEnum::values()[array_rand(CommentStatusEnum::values())]
        ];
    }
}
