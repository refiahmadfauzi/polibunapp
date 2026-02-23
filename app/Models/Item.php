<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'price',
        'stock',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
    ];

    public function pharmacyTransactions(): BelongsToMany
    {
        return $this->belongsToMany(PharmacyTransaction::class , 'pharmacy_transaction_items')
            ->withPivot(['quantity', 'price', 'subtotal']);
    }
}
