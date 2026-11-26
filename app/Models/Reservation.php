<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Reservation extends Model
{
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
