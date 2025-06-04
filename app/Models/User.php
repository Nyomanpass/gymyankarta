<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
        'username',
        'nomor_telepon',
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

    public function isPendingEmailVerificatioon()
    {
        return $this->status === 'pending_email_verification';
    }

    public function isPendingAdminVerification()
    {
        return $this->status === 'pending_admin_verification';
    }
    public function isActive()
    {
        return $this->status === 'active';
    }
    public function isFrozen()
    {
        return $this->status === 'frozen';
    }
    public function isInactive()
    {
        return $this->status === 'inactive';
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isMember()
    {
        return $this->role === 'member';
    }
}
