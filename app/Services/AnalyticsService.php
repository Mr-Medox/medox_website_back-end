<?php

namespace App\Services;

use App\Models\Analytics;
use App\Models\PageView;
use Illuminate\Http\Request;

class AnalyticsService
{
    /**
     * Track a page view.
     */
    public function trackPageView(Request $request, string $pageType, ?int $pageId = null, array $additionalData = []): void
    {
        try {
            PageView::create([
                'page_type' => $pageType,
                'page_id' => $pageId,
                'page_url' => $request->fullUrl(),
                'page_title' => $additionalData['title'] ?? null,
                'session_id' => $this->getSessionId($request),
                'user_id' => auth()->id(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'referrer' => $request->header('referer'),
                'utm_source' => $request->get('utm_source'),
                'utm_medium' => $request->get('utm_medium'),
                'utm_campaign' => $request->get('utm_campaign'),
                'time_on_page' => $additionalData['time_on_page'] ?? 0,
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to track page view: ' . $e->getMessage());
        }
    }

    /**
     * Track a custom event.
     */
    public function trackEvent(Request $request, string $event, string $category = null, array $properties = []): void
    {
        try {
            Analytics::create([
                'event' => $event,
                'category' => $category,
                'properties' => $properties,
                'session_id' => $this->getSessionId($request),
                'user_id' => auth()->id(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'url' => $request->fullUrl(),
                'referrer' => $request->header('referer'),
                'utm_source' => $request->get('utm_source'),
                'utm_medium' => $request->get('utm_medium'),
                'utm_campaign' => $request->get('utm_campaign'),
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to track event: ' . $e->getMessage());
        }
    }

    /**
     * Track contact form submission.
     */
    public function trackContactSubmission(Request $request, string $contactId): void
    {
        $this->trackEvent($request, 'contact_form_submitted', 'conversion', [
            'contact_id' => $contactId,
            'form_source' => 'website',
        ]);
    }

    /**
     * Track blog post view.
     */
    public function trackBlogView(Request $request, string $blogSlug, int $blogId): void
    {
        $this->trackPageView($request, 'blog', $blogId, [
            'title' => 'Blog Post: ' . $blogSlug,
        ]);

        $this->trackEvent($request, 'blog_post_viewed', 'content', [
            'blog_slug' => $blogSlug,
            'blog_id' => $blogId,
        ]);
    }

    /**
     * Track portfolio project view.
     */
    public function trackPortfolioView(Request $request, string $portfolioSlug, int $portfolioId): void
    {
        $this->trackPageView($request, 'portfolio', $portfolioId, [
            'title' => 'Portfolio Project: ' . $portfolioSlug,
        ]);

        $this->trackEvent($request, 'portfolio_viewed', 'content', [
            'portfolio_slug' => $portfolioSlug,
            'portfolio_id' => $portfolioId,
        ]);
    }

    /**
     * Get analytics statistics.
     */
    public function getAnalyticsStats(int $days = 30): array
    {
        $startDate = now()->subDays($days);

        return [
            'page_views' => PageView::where('created_at', '>=', $startDate)->count(),
            'unique_sessions' => PageView::where('created_at', '>=', $startDate)
                ->distinct('session_id')
                ->count('session_id'),
            'top_pages' => PageView::where('created_at', '>=', $startDate)
                ->selectRaw('page_type, page_id, COUNT(*) as views')
                ->groupBy('page_type', 'page_id')
                ->orderBy('views', 'desc')
                ->limit(10)
                ->get(),
            'events' => Analytics::where('created_at', '>=', $startDate)
                ->selectRaw('event, COUNT(*) as count')
                ->groupBy('event')
                ->orderBy('count', 'desc')
                ->get(),
            'referrers' => PageView::where('created_at', '>=', $startDate)
                ->whereNotNull('referrer')
                ->selectRaw('referrer, COUNT(*) as count')
                ->groupBy('referrer')
                ->orderBy('count', 'desc')
                ->limit(10)
                ->get(),
        ];
    }

    /**
     * Get session ID from request.
     */
    private function getSessionId(Request $request): string
    {
        return $request->session()->getId() ?: uniqid('session_', true);
    }
}
