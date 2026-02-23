<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PharmacyTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'date',
        'total_amount',
    ];

    protected $casts = [
        'date' => 'date',
        'total_amount' => 'decimal:2',
    ];

    public function items(): BelongsToMany
    {
        return $this->belongsToMany(Item::class , 'pharmacy_transaction_items')
            ->withPivot(['quantity', 'price', 'subtotal']);
    }

    public function transactionItems(): HasMany
    {
        return $this->hasMany(PharmacyTransactionItem::class);
    }
}
