<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Reservation extends Model
{
    protected static function booted(): void
    {
        static::created(function (Reservation $reservation) {
            AdminNotification::record('booking_created', "Reservation #{$reservation->id} was booked.");
        });

        static::updated(function (Reservation $reservation) {
            if ($reservation->wasChanged('status') && $reservation->status === 'cancelled') {
                AdminNotification::record('booking_cancelled', "Reservation #{$reservation->id} was cancelled.");
            }
        });
    }

    public function guest(): BelongsTo
    {
        return $this->belongsTo(Guest::class, 'guest_id');
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class, 'room_id', 'room_id');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
}
