<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PharmacyTransactionItem extends Model
{
    public $timestamps = false;

    protected $table = 'pharmacy_transaction_items';

    protected $fillable = [
        'pharmacy_transaction_id',
        'item_id',
        'quantity',
        'price',
        'subtotal',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'quantity' => 'integer',
    ];

    public function pharmacyTransaction(): BelongsTo
    {
        return $this->belongsTo(PharmacyTransaction::class);
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }
}
