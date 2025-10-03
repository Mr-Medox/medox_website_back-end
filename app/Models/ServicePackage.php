<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicePackage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'duration',
        'features',
        'popular',
        'published',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'features' => 'array',
            'popular' => 'boolean',
            'published' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    /**
     * Scope a query to only include published packages.
     */
    public function scopePublished($query)
    {
        return $query->where('published', true);
    }

    /**
     * Scope a query to only include popular packages.
     */
    public function scopePopular($query)
    {
        return $query->where('popular', true);
    }

    /**
     * Scope a query to order by sort order.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('created_at', 'desc');
    }
}
