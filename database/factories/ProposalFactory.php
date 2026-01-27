<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Proposal>
 */
class ProposalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'freelancer_id' => User::inRandomOrder()->value('id'),
            'project_id' => Project::factory(),//Project::inRandomOrder()->value('id'),
            'description' => fake()->paragraph(3),
            'cost' => fake()->randomFloat(2, 50, 3000),
            'duration' => fake()->numberBetween(1, 30),
            'duration_unit' => fake()->randomElement(['day', 'week', 'month', 'year']),
            'status' => fake()->randomElement(['pending', 'accepted', 'declined']),
        ];
    }
}
