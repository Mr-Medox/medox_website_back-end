<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Portfolio>
 */
class PortfolioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->words(3, true);
        $technologies = fake()->randomElements(['React', 'Vue.js', 'Laravel', 'Node.js', 'Python', 'PHP', 'MySQL', 'PostgreSQL', 'MongoDB', 'Docker', 'AWS'], fake()->numberBetween(3, 6));
        
        return [
            'title' => $title,
            'slug' => \Illuminate\Support\Str::slug($title),
            'description' => fake()->paragraph(3),
            'content' => fake()->paragraphs(8, true),
            'featured_image' => fake()->imageUrl(1200, 800, 'business'),
            'gallery' => [
                fake()->imageUrl(800, 600, 'business'),
                fake()->imageUrl(800, 600, 'business'),
                fake()->imageUrl(800, 600, 'business'),
            ],
            'category' => fake()->randomElement(['Web Development', 'Mobile App', 'E-commerce', 'SaaS Platform', 'Landing Page']),
            'industry' => fake()->randomElement(['Technology', 'Healthcare', 'Finance', 'Education', 'E-commerce', 'Real Estate']),
            'technologies' => $technologies,
            'features' => fake()->words(5),
            'live_url' => fake()->url(),
            'github_url' => 'https://github.com/user/' . fake()->slug(),
            'featured' => fake()->boolean(30),
            'published' => true,
            'sort_order' => fake()->numberBetween(0, 100),
            'views' => fake()->numberBetween(0, 2000),
            'project_duration' => fake()->randomElement(['2 weeks', '1 month', '2 months', '3 months', '6 months']),
            'project_budget' => fake()->randomElement(['$5,000 - $10,000', '$10,000 - $25,000', '$25,000 - $50,000', '$50,000+']),
            'client_name' => fake()->company(),
            'results' => fake()->paragraph(2),
            'challenge' => fake()->paragraph(2),
            'solution' => fake()->paragraph(2),
            'impact' => fake()->paragraph(2),
            'seo_title' => $title,
            'seo_description' => fake()->sentence(15),
            'author_id' => User::factory(),
        ];
    }

    /**
     * Indicate that the portfolio is featured.
     */
    public function featured(): static
    {
        return $this->state(fn (array $attributes) => [
            'featured' => true,
            'published' => true,
        ]);
    }
}
