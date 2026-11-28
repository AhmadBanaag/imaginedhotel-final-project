<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReservationRequest;
use App\Services\ReservationService;
use Illuminate\Http\RedirectResponse;

class ReservationController extends Controller
{
    public function store(StoreReservationRequest $request, ReservationService $service): RedirectResponse
    {
        $booking = $service->book($request->validated(), $request->user()?->id);

        return back()->with('booking_status', "Reservation {$booking->reservation_code} saved for {$booking->room->room_number}.");
    }
}