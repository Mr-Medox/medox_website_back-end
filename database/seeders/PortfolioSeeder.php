<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\Contact;
use App\Models\MediaFile;
use App\Models\NewsletterSubscriber;
use App\Models\Portfolio;
use App\Models\Service;
use App\Models\ServicePackage;
use App\Models\SiteSetting;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Database\Seeder;

class PortfolioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@portfolio.com',
            'password' => bcrypt('password'),
            'role' => 'super_admin',
            'is_active' => true,
        ]);

        // Create additional users
        User::factory(3)->create();

        // Create site settings
        $this->createSiteSettings();

        // Create services
        $this->createServices();

        // Create service packages
        $this->createServicePackages();

        // Create portfolios
        Portfolio::factory(10)->create();
        Portfolio::factory(3)->featured()->create();

        // Create blogs
        Blog::factory(15)->create();
        Blog::factory(5)->featured()->create();

        // Create testimonials
        $this->createTestimonials();

        // Create contacts
        Contact::factory(20)->create();

        // Create newsletter subscribers
        NewsletterSubscriber::factory(50)->create();

        // Create media files
        MediaFile::factory(30)->create([
            'uploaded_by' => $admin->id,
        ]);
    }

    private function createSiteSettings(): void
    {
        $settings = [
            // General Settings
            ['key' => 'site_name', 'value' => 'Portfolio Website', 'type' => 'text', 'category' => 'general', 'is_public' => true],
            ['key' => 'site_description', 'value' => 'Professional portfolio showcasing web development projects and services', 'type' => 'textarea', 'category' => 'general', 'is_public' => true],
            ['key' => 'site_logo', 'value' => '/images/logo.png', 'type' => 'image', 'category' => 'general', 'is_public' => true],
            ['key' => 'site_favicon', 'value' => '/images/favicon.ico', 'type' => 'image', 'category' => 'general', 'is_public' => true],
            
            // Contact Settings
            ['key' => 'contact_email', 'value' => 'contact@portfolio.com', 'type' => 'text', 'category' => 'contact', 'is_public' => true],
            ['key' => 'contact_phone', 'value' => '+1 (555) 123-4567', 'type' => 'text', 'category' => 'contact', 'is_public' => true],
            ['key' => 'contact_address', 'value' => '123 Main St, City, State 12345', 'type' => 'textarea', 'category' => 'contact', 'is_public' => true],
            
            // Social Media
            ['key' => 'social_github', 'value' => 'https://github.com/username', 'type' => 'text', 'category' => 'social', 'is_public' => true],
            ['key' => 'social_linkedin', 'value' => 'https://linkedin.com/in/username', 'type' => 'text', 'category' => 'social', 'is_public' => true],
            ['key' => 'social_twitter', 'value' => 'https://twitter.com/username', 'type' => 'text', 'category' => 'social', 'is_public' => true],
            
            // SEO Settings
            ['key' => 'default_meta_title', 'value' => 'Portfolio Website - Web Developer', 'type' => 'text', 'category' => 'seo', 'is_public' => false],
            ['key' => 'default_meta_description', 'value' => 'Professional web developer portfolio showcasing projects and services', 'type' => 'textarea', 'category' => 'seo', 'is_public' => false],
            ['key' => 'google_analytics_id', 'value' => 'GA-XXXXXXXXX', 'type' => 'text', 'category' => 'analytics', 'is_public' => false],
        ];

        foreach ($settings as $setting) {
            SiteSetting::create($setting);
        }
    }

    private function createServices(): void
    {
        $services = [
            [
                'title' => 'Web Development',
                'description' => 'Custom web applications built with modern technologies',
                'features' => ['Responsive Design', 'SEO Optimized', 'Fast Loading', 'Mobile Friendly'],
                'price' => 'Starting at $2,500',
                'category' => 'Development',
                'featured' => true,
                'icon' => 'code',
                'benefits' => ['Custom Solutions', 'Scalable Architecture', 'Maintenance Support'],
            ],
            [
                'title' => 'Mobile App Development',
                'description' => 'Native and cross-platform mobile applications',
                'features' => ['iOS & Android', 'Cross-Platform', 'App Store Optimization', 'Push Notifications'],
                'price' => 'Starting at $5,000',
                'category' => 'Development',
                'featured' => true,
                'icon' => 'smartphone',
                'benefits' => ['Native Performance', 'Offline Support', 'Regular Updates'],
            ],
            [
                'title' => 'UI/UX Design',
                'description' => 'Beautiful and intuitive user interfaces',
                'features' => ['User Research', 'Wireframing', 'Prototyping', 'Design Systems'],
                'price' => 'Starting at $1,500',
                'category' => 'Design',
                'featured' => false,
                'icon' => 'palette',
                'benefits' => ['User-Centered Design', 'Modern Aesthetics', 'Accessibility'],
            ],
            [
                'title' => 'E-commerce Solutions',
                'description' => 'Complete online store setup and management',
                'features' => ['Product Management', 'Payment Integration', 'Inventory Tracking', 'Order Management'],
                'price' => 'Starting at $3,500',
                'category' => 'E-commerce',
                'featured' => true,
                'icon' => 'shopping-cart',
                'benefits' => ['Secure Payments', 'Inventory Management', 'Analytics Dashboard'],
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }

    private function createServicePackages(): void
    {
        $packages = [
            [
                'name' => 'Starter Package',
                'description' => 'Perfect for small businesses and personal projects',
                'price' => '$2,500',
                'duration' => '2-3 weeks',
                'features' => ['5 Pages', 'Responsive Design', 'Contact Form', 'Basic SEO', '1 Month Support'],
                'popular' => false,
            ],
            [
                'name' => 'Professional Package',
                'description' => 'Ideal for growing businesses and startups',
                'price' => '$5,000',
                'duration' => '4-6 weeks',
                'features' => ['10 Pages', 'Custom Design', 'CMS Integration', 'Advanced SEO', 'Analytics Setup', '3 Months Support'],
                'popular' => true,
            ],
            [
                'name' => 'Enterprise Package',
                'description' => 'Complete solution for large organizations',
                'price' => '$10,000+',
                'duration' => '8-12 weeks',
                'features' => ['Unlimited Pages', 'Custom Features', 'API Integration', 'Advanced Analytics', 'Priority Support', '6 Months Support'],
                'popular' => false,
            ],
        ];

        foreach ($packages as $package) {
            ServicePackage::create($package);
        }
    }

    private function createTestimonials(): void
    {
        $testimonials = [
            [
                'name' => 'John Smith',
                'role' => 'CEO',
                'company' => 'TechStart Inc.',
                'content' => 'Outstanding work! The website exceeded our expectations and helped us increase our online presence significantly.',
                'rating' => 5,
                'project' => 'Corporate Website',
                'featured' => true,
                'verified' => true,
            ],
            [
                'name' => 'Sarah Johnson',
                'role' => 'Marketing Director',
                'company' => 'Creative Agency',
                'content' => 'Professional, reliable, and delivered exactly what we needed. Highly recommended for any web development project.',
                'rating' => 5,
                'project' => 'E-commerce Platform',
                'featured' => true,
                'verified' => true,
            ],
            [
                'name' => 'Mike Davis',
                'role' => 'Founder',
                'company' => 'StartupXYZ',
                'content' => 'The mobile app development was flawless. Great communication throughout the project and excellent final result.',
                'rating' => 5,
                'project' => 'Mobile Application',
                'featured' => false,
                'verified' => true,
            ],
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::create($testimonial);
        }
    }
}
