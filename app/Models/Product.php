<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'is_available'
    ];

    protected $casts = [
        'is_available' => 'boolean',
        'price' => 'decimal:2',
    ];

    // Relasi
    public function transactionItems()
    {
        return $this->hasMany(TransactionItem::class);
    }

    // Scope untuk mendapatkan produk yang tersedia
    public function scopeAvailable($query)
    {
        return $query->where('is_available', true);
    }

    public function scopeUnavailable($query)
    {
        return $query->where('is_available', false);
    }

    // helper method
    public function isAvailable()
    {
        return $this->is_available;
    }

    public function toggleAvailability()
    {
        $this->update(['is_available' => !$this->is_available]);
    }
}
