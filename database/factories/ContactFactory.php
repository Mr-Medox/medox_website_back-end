<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contact>
 */
class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'company' => fake()->company(),
            'subject' => fake()->sentence(4),
            'message' => fake()->paragraphs(3, true),
            'project_type' => fake()->randomElement(['Web Development', 'Mobile App', 'E-commerce', 'Consulting', 'Maintenance']),
            'budget' => fake()->randomElement(['Under $5,000', '$5,000 - $10,000', '$10,000 - $25,000', '$25,000+']),
            'timeline' => fake()->randomElement(['ASAP', '1 month', '2-3 months', '6+ months']),
            'status' => fake()->randomElement(['new', 'read', 'replied', 'closed']),
            'priority' => fake()->randomElement(['low', 'medium', 'high']),
            'source' => fake()->randomElement(['website', 'referral', 'social_media', 'google_ads']),
            'ip_address' => fake()->ipv4(),
            'user_agent' => fake()->userAgent(),
            'referrer' => fake()->url(),
            'utm_source' => fake()->randomElement(['google', 'facebook', 'twitter', 'linkedin']),
            'utm_medium' => fake()->randomElement(['cpc', 'social', 'organic', 'email']),
            'utm_campaign' => fake()->words(2, true),
            'notes' => fake()->paragraph(),
            'assigned_to' => User::factory(),
        ];
    }

    /**
     * Indicate that the contact is new.
     */
    public function new(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'new',
            'priority' => 'medium',
        ]);
    }

    /**
     * Indicate that the contact is high priority.
     */
    public function highPriority(): static
    {
        return $this->state(fn (array $attributes) => [
            'priority' => 'high',
        ]);
    }
}
