<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Scholarship extends Model
{
    protected $fillable = [
        'title',
        'provider',
        'description',
        'deadline',
        'minimum_gwa',
        'required_course',
        'municipality',
        'year_level',        // ← ADDED
        'benefits',
        'application_link',
        'source_url',
        'source_type',
        'organization_name',
        'is_active',
    ];

    protected $casts = [
        'deadline'    => 'date',
        'minimum_gwa' => 'decimal:2',
        'is_active'   => 'boolean',
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