<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Freelancer>
 */
class FreelancerFactory extends Factory
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
            'first_name' => fake()->firstName(),
            'last_name'  => fake()->lastName(),

            'title' => fake()->optional()->jobTitle(),

            'country' => fake()->country(),

            'verified' => fake()->boolean(30), // 30% verified

            'description' => fake()->optional()->paragraph(3),

            'hourly_rate' => fake()->optional()->randomFloat(2, 5, 100),

            'profile_photo_path' => fake()->optional()->imageUrl(300, 300, 'people'),

            'gender' => fake()->optional()->randomElement(['male', 'female']),

            'birth_date' => fake()->optional()->date('Y-m-d'),
        ];
    }
}
