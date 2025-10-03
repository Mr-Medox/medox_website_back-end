<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'features',
        'price',
        'category',
        'featured',
        'published',
        'sort_order',
        'icon',
        'benefits',
    ];

    protected function casts(): array
    {
        return [
            'features' => 'array',
            'benefits' => 'array',
            'featured' => 'boolean',
            'published' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    /**
     * Scope a query to only include published services.
     */
    public function scopePublished($query)
    {
        return $query->where('published', true);
    }

    /**
     * Scope a query to only include featured services.
     */
    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    /**
     * Scope a query to filter by category.
     */
    public function scopeCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope a query to order by sort order.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('created_at', 'desc');
    }
}
