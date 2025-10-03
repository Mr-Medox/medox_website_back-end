<?php

namespace App\Services;

use App\Models\Blog;
use App\Models\Portfolio;
use App\Models\SeoMeta;

class SeoService
{
    /**
     * Generate meta tags for a page.
     */
    public function generateMetaTags(string $pageType, ?int $pageId = null, array $defaults = []): array
    {
        $seoMeta = SeoMeta::getForPage($pageType, $pageId);
        
        if (!$seoMeta) {
            return $this->getDefaultMetaTags($pageType, $defaults);
        }

        return [
            'title' => $seoMeta->meta_title ?: $defaults['title'] ?? '',
            'description' => $seoMeta->meta_description ?: $defaults['description'] ?? '',
            'keywords' => $seoMeta->meta_keywords ?: $defaults['keywords'] ?? '',
            'og_title' => $seoMeta->og_title ?: $seoMeta->meta_title ?: $defaults['title'] ?? '',
            'og_description' => $seoMeta->og_description ?: $seoMeta->meta_description ?: $defaults['description'] ?? '',
            'og_image' => $seoMeta->og_image ?: $defaults['image'] ?? '',
            'twitter_title' => $seoMeta->twitter_title ?: $seoMeta->meta_title ?: $defaults['title'] ?? '',
            'twitter_description' => $seoMeta->twitter_description ?: $seoMeta->meta_description ?: $defaults['description'] ?? '',
            'twitter_image' => $seoMeta->twitter_image ?: $seoMeta->og_image ?: $defaults['image'] ?? '',
            'canonical_url' => $seoMeta->canonical_url ?: $defaults['url'] ?? '',
            'robots' => $seoMeta->robots ?: 'index,follow',
        ];
    }

    /**
     * Get default meta tags for a page type.
     */
    private function getDefaultMetaTags(string $pageType, array $defaults = []): array
    {
        $siteName = $this->getSiteSetting('site_name', 'Portfolio Website');
        $siteDescription = $this->getSiteSetting('site_description', 'Professional portfolio website');

        $defaultTitles = [
            'home' => $defaults['title'] ?? $siteName,
            'blog' => $defaults['title'] ?? 'Blog - ' . $siteName,
            'portfolio' => $defaults['title'] ?? 'Portfolio - ' . $siteName,
            'contact' => $defaults['title'] ?? 'Contact - ' . $siteName,
            'about' => $defaults['title'] ?? 'About - ' . $siteName,
            'services' => $defaults['title'] ?? 'Services - ' . $siteName,
        ];

        return [
            'title' => $defaultTitles[$pageType] ?? $siteName,
            'description' => $defaults['description'] ?? $siteDescription,
            'keywords' => $defaults['keywords'] ?? 'web development, portfolio, laravel, react',
            'og_title' => $defaultTitles[$pageType] ?? $siteName,
            'og_description' => $defaults['description'] ?? $siteDescription,
            'og_image' => $defaults['image'] ?? $this->getSiteSetting('site_logo', ''),
            'twitter_title' => $defaultTitles[$pageType] ?? $siteName,
            'twitter_description' => $defaults['description'] ?? $siteDescription,
            'twitter_image' => $defaults['image'] ?? $this->getSiteSetting('site_logo', ''),
            'canonical_url' => $defaults['url'] ?? '',
            'robots' => 'index,follow',
        ];
    }

    /**
     * Generate structured data for a blog post.
     */
    public function generateBlogStructuredData(Blog $blog): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'BlogPosting',
            'headline' => $blog->title,
            'description' => $blog->excerpt,
            'image' => $blog->featured_image,
            'author' => [
                '@type' => 'Person',
                'name' => $blog->author->name,
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => $this->getSiteSetting('site_name', 'Portfolio Website'),
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => $this->getSiteSetting('site_logo', ''),
                ],
            ],
            'datePublished' => $blog->created_at->toISOString(),
            'dateModified' => $blog->updated_at->toISOString(),
            'mainEntityOfPage' => [
                '@type' => 'WebPage',
                '@id' => url('/blog/' . $blog->slug),
            ],
        ];
    }

    /**
     * Generate structured data for a portfolio project.
     */
    public function generatePortfolioStructuredData(Portfolio $portfolio): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'CreativeWork',
            'name' => $portfolio->title,
            'description' => $portfolio->description,
            'image' => $portfolio->featured_image,
            'creator' => [
                '@type' => 'Person',
                'name' => $portfolio->author->name,
            ],
            'dateCreated' => $portfolio->created_at->toISOString(),
            'dateModified' => $portfolio->updated_at->toISOString(),
            'url' => $portfolio->live_url,
            'keywords' => implode(', ', $portfolio->technologies ?? []),
        ];
    }

    /**
     * Generate sitemap data.
     */
    public function generateSitemapData(): array
    {
        $sitemap = [
            [
                'url' => url('/'),
                'lastmod' => now()->format('Y-m-d'),
                'changefreq' => 'daily',
                'priority' => '1.0',
            ],
            [
                'url' => url('/portfolio'),
                'lastmod' => now()->format('Y-m-d'),
                'changefreq' => 'weekly',
                'priority' => '0.8',
            ],
            [
                'url' => url('/blog'),
                'lastmod' => now()->format('Y-m-d'),
                'changefreq' => 'daily',
                'priority' => '0.8',
            ],
            [
                'url' => url('/contact'),
                'lastmod' => now()->format('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.6',
            ],
        ];

        // Add blog posts
        $blogs = Blog::published()->select('slug', 'updated_at')->get();
        foreach ($blogs as $blog) {
            $sitemap[] = [
                'url' => url('/blog/' . $blog->slug),
                'lastmod' => $blog->updated_at->format('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.7',
            ];
        }

        // Add portfolio projects
        $portfolios = Portfolio::published()->select('slug', 'updated_at')->get();
        foreach ($portfolios as $portfolio) {
            $sitemap[] = [
                'url' => url('/portfolio/' . $portfolio->slug),
                'lastmod' => $portfolio->updated_at->format('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.7',
            ];
        }

        return $sitemap;
    }

    /**
     * Get site setting value.
     */
    private function getSiteSetting(string $key, string $default = ''): string
    {
        try {
            $setting = \App\Models\SiteSetting::where('key', $key)->first();
            return $setting ? $setting->value : $default;
        } catch (\Exception $e) {
            return $default;
        }
    }
}
