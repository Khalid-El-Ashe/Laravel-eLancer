<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'category_id' => Category::factory(),
            'title' => fake()->sentence(4),
            'description' => fake()->paragraph(3),

            'status' => fake()->randomElement(['open', 'in-progress', 'closed']),
            'type' => fake()->randomElement(['fixed', 'hourly']),

            'budget' => fake()->optional()->randomFloat(2, 100, 10000),
        ];
    }
}
