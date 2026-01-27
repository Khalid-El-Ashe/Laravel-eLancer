<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->words(2, true),
            'slug' => fake()->unique()->slug(),

            'description' => fake()->optional()->paragraph(2),

            'art_path' => fake()->optional()->imageUrl(640, 480, 'business'),

            'parent_id' => fake()->optional(0.3)->randomElement(Category::pluck('id')->toArray())
        ];
    }
}
