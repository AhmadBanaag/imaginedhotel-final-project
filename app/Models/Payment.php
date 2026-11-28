<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $attributes = [
        'type' => 'payment',
        'status' => 'pending',
    ];

    protected static function booted(): void
    {
        static::created(function (Payment $payment) {
            if ($payment->type === 'payment' && $payment->status === 'pending') {
                AdminNotification::record(
                    'payment_submitted',
                    "Payment #{$payment->id} for reservation #{$payment->reservation_id} needs verification."
                );
            }
        });
    }

    public function reservation(): BelongsTo
    {
    return $this->belongsTo(Reservation::class);
    }

    public function paymentMethod(): BelongsTo
    {
    return $this->belongsTo(PaymentMethod::class);
    }
}
