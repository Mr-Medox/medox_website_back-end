<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PageView extends Model
{
    use HasFactory;

    protected $fillable = [
        'page_type',
        'page_id',
        'page_url',
        'page_title',
        'session_id',
        'user_id',
        'ip_address',
        'user_agent',
        'referrer',
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'time_on_page',
    ];

    protected function casts(): array
    {
        return [
            'time_on_page' => 'integer',
            'created_at' => 'datetime',
        ];
    }

    public $timestamps = false;

    /**
     * Get the user that owns the page view.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

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
     * Scope a query to filter by session.
     */
    public function scopeSession($query, $sessionId)
    {
        return $query->where('session_id', $sessionId);
    }

    /**
     * Scope a query to get recent page views.
     */
    public function scopeRecent($query, $days = 7)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }
}
