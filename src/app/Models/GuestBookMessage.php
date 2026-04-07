<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuestBookMessage extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'last_name',
        'first_name',
        'middle_name',
        'email',
        'message',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];
}
