<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'municipality',
        'course',
        'gwa',
        'year_level',
        'is_admin',
        'email_notifications',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'is_admin'            => 'boolean',
        'email_notifications' => 'boolean',
        'gwa'                 => 'decimal:2',
    ];

    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
}