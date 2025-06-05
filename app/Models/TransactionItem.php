<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'product_id',
        'quantity',
        'price_per_unit',
        'sub_total',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'price_per_unit' => 'decimal:2',
        'sub_total' => 'decimal:2',
    ];

    // Relasi
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // mutator untuk otomatis menghitung sub_total
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($transactionItem) {
            $transactionItem->sub_total = $transactionItem->quantity * $transactionItem->price_per_unit;
        });
    }
}
