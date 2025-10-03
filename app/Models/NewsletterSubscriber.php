<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsletterSubscriber extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'name',
        'status',
        'source',
        'subscribed_at',
        'unsubscribed_at',
        'last_email_sent',
    ];

    protected function casts(): array
    {
        return [
            'subscribed_at' => 'datetime',
            'unsubscribed_at' => 'datetime',
            'last_email_sent' => 'datetime',
        ];
    }

    /**
     * Scope a query to only include active subscribers.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include unsubscribed subscribers.
     */
    public function scopeUnsubscribed($query)
    {
        return $query->where('status', 'unsubscribed');
    }

    /**
     * Scope a query to only include bounced subscribers.
     */
    public function scopeBounced($query)
    {
        return $query->where('status', 'bounced');
    }

    /**
     * Scope a query to filter by source.
     */
    public function scopeSource($query, $source)
    {
        return $query->where('source', $source);
    }

    /**
     * Scope a query to get recent subscribers.
     */
    public function scopeRecent($query, $days = 30)
    {
        return $query->where('subscribed_at', '>=', now()->subDays($days));
    }

    /**
     * Mark subscriber as unsubscribed.
     */
    public function unsubscribe()
    {
        $this->update([
            'status' => 'unsubscribed',
            'unsubscribed_at' => now(),
        ]);
    }

    /**
     * Mark subscriber as bounced.
     */
    public function markAsBounced()
    {
        $this->update(['status' => 'bounced']);
    }
}
