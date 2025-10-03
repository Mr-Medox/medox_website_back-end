<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'avatar',
        'last_login',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_login' => 'datetime',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the blogs for the user.
     */
    public function blogs()
    {
        return $this->hasMany(Blog::class, 'author_id');
    }

    /**
     * Get the portfolios for the user.
     */
    public function portfolios()
    {
        return $this->hasMany(Portfolio::class, 'author_id');
    }

    /**
     * Get the contacts assigned to the user.
     */
    public function assignedContacts()
    {
        return $this->hasMany(Contact::class, 'assigned_to');
    }

    /**
     * Get the media files uploaded by the user.
     */
    public function mediaFiles()
    {
        return $this->hasMany(MediaFile::class, 'uploaded_by');
    }
}
