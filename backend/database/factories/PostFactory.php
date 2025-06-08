<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(), // userを自動で生成して関連付ける
            'title' => $this->faker->realText(30, 2), // 30文字のタイトルを生成
            'content' => $this->faker->realText(200, 2), // 200文字のコンテンツを生成
        ];
    }
}
