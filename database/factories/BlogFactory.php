<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Blog>
 */
class BlogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence(6);
        
        return [
            'title' => $title,
            'slug' => \Illuminate\Support\Str::slug($title),
            'excerpt' => fake()->paragraph(2),
            'content' => fake()->paragraphs(10, true),
            'featured_image' => fake()->imageUrl(800, 600, 'business'),
            'meta_title' => $title,
            'meta_description' => fake()->sentence(15),
            'published' => fake()->boolean(80),
            'featured' => fake()->boolean(20),
            'category' => fake()->randomElement(['Web Development', 'Mobile Development', 'UI/UX Design', 'Digital Marketing', 'SEO']),
            'tags' => fake()->words(3),
            'read_time' => fake()->numberBetween(3, 15),
            'views' => fake()->numberBetween(0, 1000),
            'seo_score' => fake()->numberBetween(60, 100),
            'author_id' => User::factory(),
        ];
    }

    /**
     * Indicate that the blog is published.
     */
    public function published(): static
    {
        return $this->state(fn (array $attributes) => [
            'published' => true,
        ]);
    }

    /**
     * Indicate that the blog is featured.
     */
    public function featured(): static
    {
        return $this->state(fn (array $attributes) => [
            'featured' => true,
            'published' => true,
        ]);
    }
}
