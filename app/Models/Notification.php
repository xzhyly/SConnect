<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'user_id',
        'scholarship_id',
        'type',
        'is_read',
        'email_sent',
    ];

    protected $casts = [
        'is_read'    => 'boolean',
        'email_sent' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scholarship()
    {
        return $this->belongsTo(Scholarship::class);
    }
}