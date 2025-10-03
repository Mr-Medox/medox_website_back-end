<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Redirect extends Model
{
    use HasFactory;

    protected $fillable = [
        'from_url',
        'to_url',
        'status_code',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'status_code' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Scope a query to only include active redirects.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Find a redirect by from URL.
     */
    public static function findRedirect($fromUrl)
    {
        return static::active()
            ->where('from_url', $fromUrl)
            ->first();
    }

    /**
     * Create a redirect.
     */
    public static function createRedirect($fromUrl, $toUrl, $statusCode = 301)
    {
        return static::create([
            'from_url' => $fromUrl,
            'to_url' => $toUrl,
            'status_code' => $statusCode,
            'is_active' => true,
        ]);
    }
}
