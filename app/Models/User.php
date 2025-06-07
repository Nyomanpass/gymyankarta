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
        'username',
        'email',
        'password',
        'nomor_telepon',
        'role',
        'status',
        'member_type',
        'membership_started_date',
        'membership_expiration_date',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'membership_started_date' => 'date',
        'membership_expiration_date' => 'date',
        'password' => 'hashed',
    ];

    // Relasi
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    // Scope untuk filter berdasarkan role
    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }

    public function scopeMembers($query)
    {
        return $query->where('role', 'member');
    }

    // Scope untuk filter berdasarkan status
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopePendingVerification($query)
    {
        return $query->where('status', 'pending_admin_verification');
    }

    // Helper methods
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isMember()
    {
        return $this->role === 'member';
    }

    public function isActive()
    {
        return $this->status === 'active';
    }

    public function membershipExpired()
    {
        return $this->membership_expiration_date && $this->membership_expiration_date->isPast();
    }

    public function canAttendToday()
    {
        if (!$this->isActive() || $this->membershipExpired()) {
            return false;
        }

        // Cek apakah sudah absen hari ini
        return !$this->attendances()
            ->whereDate('check_in_datetime', today())
            ->exists();
    }
}