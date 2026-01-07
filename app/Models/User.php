<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_banned'
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_banned' => 'boolean',
    ];

    const ROLE_MASTER = 'master';
    const ROLE_MODERATOR = 'moderator';
    const ROLE_USER = 'user';

    public function isMaster(): bool
    {
        return $this->role === self::ROLE_MASTER;
    }

    public function isModerator(): bool
    {
        return $this->role === self::ROLE_MODERATOR;
    }

    public function isBanned(): bool
    {
        return $this->is_banned;
    }
    public function isReportable(): bool
    {
        return !$this->isMaster();
    }

    public function reportsMade()
    {
        return $this->hasMany(UserReport::class, 'reporter_id');
    }

    public function reportsReceived()
    {
        return $this->hasMany(UserReport::class, 'reported_id');
    }
}
