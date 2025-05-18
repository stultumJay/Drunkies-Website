<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $primaryKey = 'payment_id';

    protected $fillable = [
        'user_id',
        'provider',
        'last_four_digits',
        'token',
        'expiry_month',
        'expiry_year',
        'is_default',
    ];

    protected $hidden = [
        'token',
    ];

    protected $casts = [
        'is_default' => 'boolean',
        'expiry_month' => 'integer',
        'expiry_year' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'payment_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'payment_id');
    }

    public function getExpiryDateAttribute()
    {
        return sprintf('%02d/%d', $this->expiry_month, $this->expiry_year);
    }

    public function getMaskedNumberAttribute()
    {
        return "****{$this->last_four_digits}";
    }
} 