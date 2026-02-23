<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    const USER_TYPE_ADMIN = 'admin';
    const USER_TYPE_TECH = 'tech';
    const USER_TYPE_USER = 'user';

    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type',
        'company',
        'phone',
        'email_verified_at',

    ];

    protected $hidden = [
        'password',
        'remember_token',

    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $attributes = [
        'user_type' => self::USER_TYPE_USER,

    ];

    public function isAdmin(): bool
    {
        return $this->user_type === self::USER_TYPE_ADMIN;
    }

    public function isTech(): bool
    {
        return $this->user_type === self::USER_TYPE_TECH;
    }

    public function isUser(): bool
    {
        return $this->user_type === self::USER_TYPE_USER;
    }

   

    // Scope for different user types
    public function scopeAdmins($query)
    {
        return $query->where('user_type', self::USER_TYPE_ADMIN);
    }

    public function scopeTechs($query)
    {
        return $query->where('user_type', self::USER_TYPE_TECH);
    }

    public function scopeUsers($query)
    {
        return $query->where('user_type', self::USER_TYPE_USER);
    }

    
}