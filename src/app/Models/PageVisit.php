<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageVisit extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'visited_at',
        'page',
        'ip_address',
        'hostname',
        'user_agent',
    ];

    protected $casts = [
        'visited_at' => 'datetime',
    ];
}
