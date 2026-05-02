<?php
// app/Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'last_name',
        'first_name',
        'middle_name',
        'email',
        'login',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getFullNameAttribute(): string
    {
        if ($this->last_name && $this->first_name) {
            return trim("{$this->last_name} {$this->first_name} {$this->middle_name}");
        }

        return $this->name;
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
