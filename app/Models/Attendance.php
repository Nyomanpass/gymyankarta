<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'check_in_datetime',
    ];

    protected $casts = [
        'check_in_datetime' => 'datetime',
    ];

    // Relasi
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scope untuk mendapatkan kehadiran hari ini
    public function scopeToday($query)
    {
        return $query->whereDate('check_in_datetime', today());
    }

    public function scopeThisWeek($query)
    {
        return $query->whereBetween('check_in_datetime', [
            now()->startOfWeek(),
            now()->endOfWeek()
        ]);
    }

    public function scopeThisMonth($query)
    {
        return $query->whereMonth('check_in_datetime', now()->month)
            ->whereYear('check_in_datetime', now()->year);
    }

    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('check_in_datetime', [$startDate, $endDate]);
    }
}
