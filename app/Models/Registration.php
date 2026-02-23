<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Registration extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'registration_date',
        'medical_staff_id',
        'status',
    ];

    protected $casts = [
        'registration_date' => 'date',
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function medicalStaff(): BelongsTo
    {
        return $this->belongsTo(User::class , 'medical_staff_id');
    }

    public function medicalService(): HasOne
    {
        return $this->hasOne(MedicalService::class);
    }

    public function cashierTransaction(): HasOne
    {
        return $this->hasOne(CashierTransaction::class);
    }
}
