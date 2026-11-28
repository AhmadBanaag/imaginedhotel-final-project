<?php

namespace App\Services;

use App\Models\Guest;
use App\Models\Reservation;
use App\Models\Room;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Carbon\CarbonImmutable;
use InvalidArgumentException;

class ReservationService
{
    public function book(array $details, ?int $userId): Reservation
    {
        $categories = [
            'single' => 'Single-bed-room', 'double' => 'Double-bed-room',
            'family' => 'Family-Room', 'superior' => 'Suite',
        ];

        return DB::transaction(function () use ($details, $userId, $categories) {
            $rooms = Room::with('roomType')->where('status', 'available')
                ->whereHas('roomType', fn ($query) => $query->where('name', $categories[$details['room_type']]))
                ->orderBy('room_id')->lockForUpdate()->get();

            foreach ($rooms as $room) {
                $overlap = Reservation::where('room_id', $room->room_id)
                    ->where('status', '!=', 'cancelled')
                    ->where('check_in_date', '<', $details['check_out'])
                    ->where('check_out_date', '>', $details['check_in'])
                    ->lockForUpdate()->first();
                if ($overlap) {
                    continue;
                }

                $guest = new Guest(Arr::only($details, ['first_name', 'last_name', 'email', 'phone_number']));
                $guest->user_id = $userId;
                $guest->save();

                $reservation = new Reservation;
                $reservation->guest_id = $guest->id;
                $reservation->room()->associate($room);
                $reservation->reservation_code = 'IH-'.Str::upper(Str::random(12));
                $reservation->check_in_date = $details['check_in'];
                $reservation->check_out_date = $details['check_out'];
                $reservation->total_amount = $this->calculateStayTotalInCentavos(
                    CarbonImmutable::parse($details['check_in']),
                    CarbonImmutable::parse($details['check_out']),
                    (int) round($room->roomType->PricePerNight * 100)
                ) / 100;
                $reservation->save();
                app(PaymentService::class)->recordPending(
                    $reservation, $details['payment_method'], $details['ref_number'] ?? null
                );

                return $reservation;
            }

            throw ValidationException::withMessages(['room_type' => 'No room in this category is available for those dates.']);
        }, 3);
    }

    public function calculateStayTotalInCentavos(
        CarbonImmutable $checkIn,
        CarbonImmutable $checkOut,
        int $nightlyRateInCentavos
    ): int {
        $arrival = $checkIn->startOfDay();
        $departure = $checkOut->startOfDay();

        if ($departure <= $arrival) {
            throw new InvalidArgumentException('Check-out must be after check-in.');
        }

        $nights = (int) $arrival->diffInDays($departure);

        return $nights * $nightlyRateInCentavos;
    }
}