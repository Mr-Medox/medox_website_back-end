<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeoMeta extends Model
{
    use HasFactory;

    protected $fillable = [
        'page_type',
        'page_id',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'og_title',
        'og_description',
        'og_image',
        'twitter_title',
        'twitter_description',
        'twitter_image',
        'canonical_url',
        'robots',
    ];

    /**
     * Scope a query to filter by page type.
     */
    public function scopePageType($query, $pageType)
    {
        return $query->where('page_type', $pageType);
    }

    /**
     * Scope a query to filter by page ID.
     */
    public function scopePageId($query, $pageId)
    {
        return $query->where('page_id', $pageId);
    }

    /**
     * Get SEO meta for a specific page.
     */
    public static function getForPage($pageType, $pageId = null)
    {
        return static::where('page_type', $pageType)
            ->when($pageId, function ($query) use ($pageId) {
                return $query->where('page_id', $pageId);
            })
            ->first();
    }

    /**
     * Create or update SEO meta for a page.
     */
    public static function setForPage($pageType, $pageId, $data)
    {
        return static::updateOrCreate(
            [
                'page_type' => $pageType,
                'page_id' => $pageId,
            ],
            $data
        );
    }
}
