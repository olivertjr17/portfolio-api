<?php

namespace Database\Factories;

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
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'tech_stack' => $this->faker->randomElement(['Vue 3, Laravel', 'React, Node.js', 'CodeIgniter, MySQL']),
            'demo_link' => $this->faker->url(),
            'github_link' => 'https://github.com/example/project',
            'image' => 'https://via.placeholder.com/600x400.png?text=Project+Image',
            'is_featured' => $this->faker->boolean(),
        ];
    }
}
