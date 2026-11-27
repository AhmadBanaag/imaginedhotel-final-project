<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

#[Fillable(['room_type_id', 'room_number', 'status'])]
class Room extends Model
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;
    protected $primaryKey = 'room_id';
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    public function roomType()
    {
        return $this->belongsTo(RoomType::class, 'room_type_id', 'room_type_id');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'room_id', 'room_id');
    }
}
