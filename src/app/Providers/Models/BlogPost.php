<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'title',
        'image',
        'message',
        'author',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
