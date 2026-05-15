<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SyncLog extends Model
{
    protected $fillable = [
        'source',
        'records_fetched',
        'records_created',
        'records_updated',
        'status',
        'error_message',
    ];

    protected $casts = [
        'records_fetched'  => 'integer',
        'records_created'  => 'integer',
        'records_updated'  => 'integer',
    ];
}