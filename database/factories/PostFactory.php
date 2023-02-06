<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => fake()->sentence(mt_rand(2, 8)),
            'news_content' => collect($this->faker->paragraphs(mt_rand(5,10)))
            ->map(function($p){
                return "<p>$p</p>";
            })
            ->implode(''),
            'author' => mt_rand(1, 9)
        ];
    }
}
