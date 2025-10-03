<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MediaFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'filename',
        'original_name',
        'file_path',
        'file_size',
        'mime_type',
        'file_type',
        'alt_text',
        'caption',
        'uploaded_by',
    ];

    protected function casts(): array
    {
        return [
            'file_size' => 'integer',
        ];
    }

    /**
     * Get the user that uploaded the media file.
     */
    public function uploadedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    /**
     * Scope a query to filter by file type.
     */
    public function scopeFileType($query, $fileType)
    {
        return $query->where('file_type', $fileType);
    }

    /**
     * Scope a query to filter by MIME type.
     */
    public function scopeMimeType($query, $mimeType)
    {
        return $query->where('mime_type', 'like', $mimeType . '%');
    }

    /**
     * Scope a query to filter by uploader.
     */
    public function scopeUploadedBy($query, $userId)
    {
        return $query->where('uploaded_by', $userId);
    }

    /**
     * Get the file URL.
     */
    public function getUrlAttribute()
    {
        return asset('storage/' . $this->file_path);
    }

    /**
     * Get the file size in human readable format.
     */
    public function getHumanFileSizeAttribute()
    {
        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * Check if the file is an image.
     */
    public function isImage()
    {
        return $this->file_type === 'image';
    }

    /**
     * Check if the file is a video.
     */
    public function isVideo()
    {
        return $this->file_type === 'video';
    }

    /**
     * Check if the file is a document.
     */
    public function isDocument()
    {
        return $this->file_type === 'document';
    }
}
