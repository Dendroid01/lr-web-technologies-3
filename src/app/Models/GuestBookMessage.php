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
        'message_hash',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->message_hash = hash('sha256', $model->message);
        });
    }
}
