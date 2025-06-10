<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_datetime',
        'transaction_type',
        'description',
        'total_amount',
        'user_id',
        'payment_method',
    ];

    protected $casts = [
        'transaction_datetime' => 'datetime',
        'total_amount' => 'decimal:2',
    ];

    // Relasi
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactionItems()
    {
        return $this->hasMany(TransactionItem::class);
    }


    // Scope berdasarkan jenis transaksi
    public function scopeMembershipPayments($query)
    {
        return $query->where('transaction_type', 'membership_payment');
    }

    public function scopeDailyVisitFees($query)
    {
        return $query->where('transaction_type', 'daily_visit_fee');
    }

    public function scopeAdditionalItems($query)
    {
        return $query->where('transaction_type', 'additional_item');
    }

    // Scope berdasarkan tanggal
    public function scopeToday($query)
    {
        return $query->whereDate('transaction_datetime', today());
    }

    public function scopeThisWeek($query)
    {
        return $query->whereBetween('transaction_datetime', [
            now()->startOfWeek(),
            now()->endOfWeek()
        ]);
    }

    public function scopeThisMonth($query)
    {
        return $query->whereMonth('transaction_datetime', now()->month)
            ->whereYear('transaction_datetime', now()->year);
    }

    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('transaction_datetime', [$startDate, $endDate]);
    }

    public function getFormattedAmountAttribute()
    {
        return 'Rp ' . number_format($this->total_amount, 0, ',', '.');
    }



    //helper method
    public function isMembershipPayment()
    {
        return $this->transaction_type === 'membership_payment';
    }

    public function isDailyVisitFee()
    {
        return $this->transaction_type === 'daily_visit_fee';
    }

    public function isAdditionalItem()
    {
        return $this->transaction_type === 'additional_item';
    }
}
