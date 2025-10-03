<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Testimonial extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'role',
        'company',
        'content',
        'rating',
        'project',
        'project_id',
        'image',
        'featured',
        'published',
        'sort_order',
        'verified',
    ];

    protected function casts(): array
    {
        return [
            'rating' => 'integer',
            'featured' => 'boolean',
            'published' => 'boolean',
            'sort_order' => 'integer',
            'verified' => 'boolean',
        ];
    }

    /**
     * Get the portfolio project that owns the testimonial.
     */
    public function portfolio(): BelongsTo
    {
        return $this->belongsTo(Portfolio::class, 'project_id');
    }

    /**
     * Scope a query to only include published testimonials.
     */
    public function scopePublished($query)
    {
        return $query->where('published', true);
    }

    /**
     * Scope a query to only include featured testimonials.
     */
    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    /**
     * Scope a query to only include verified testimonials.
     */
    public function scopeVerified($query)
    {
        return $query->where('verified', true);
    }

    /**
     * Scope a query to order by sort order.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('created_at', 'desc');
    }
}
