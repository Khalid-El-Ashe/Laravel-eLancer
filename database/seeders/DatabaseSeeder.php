<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Admin;
use App\Models\Category;
use App\Models\Freelancer;
use App\Models\Proposal;
use Database\Factories\FreelancerFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Admin::factory()->count(5)->create();
        Category::factory()->count(10)->create();
        Proposal::factory()->count(15)->create();
        // Freelancer::factory()->count(8)->create();
        // Proposal::factory()->count(3)->create();
        // $this->call([
        //     AdminsTableSeeder::class,
        // ]);
    }
}
