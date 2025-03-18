<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;


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
            'user_id'=>User::factory(),
            "title"=>fake()->streetName(),
            "description"=>fake()->paragraph(30),
            'views'=>(int)random_int(0,10000),
            'likes'=>(int)random_int(0,100),
            'dislikes'=>(int)random_int(0,50),
            'slug'=>fake()->slug(),
            'poster'=>"https://picsum.photos/id/".(int)random_int(0,100)."/1000/400",
            'preview'=>"https://picsum.photos/id/".(int)random_int(0,100)."/400/400"
        ];
    }
}
