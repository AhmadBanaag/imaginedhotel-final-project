<?php

use App\Models\Guest;
use App\Models\Payment;
use App\Models\Reservation;
use Database\Seeders\ImaginedHotelInitialSeeder;
use Illuminate\Support\Facades\DB;

it('shows saved bookings, pending payments and cancellations once in the bell', function () {
    $this->seed(ImaginedHotelInitialSeeder::class);
    $room = DB::table('rooms')->where('room_number', 'Room 101')->value('room_id');
    $guest = Guest::create(['first_name' => 'Test', 'last_name' => 'Guest',
        'phone_number' => '000', 'email' => 'guest@example.test']);
    $reservation = new Reservation;
    $reservation->guest_id = $guest->id;
    $reservation->room_id = $room;
    $reservation->reservation_code = 'test-booking';
    $reservation->check_in_date = today();
    $reservation->check_out_date = today()->addDay();
    $reservation->total_amount = 999;
    $reservation->save();

    $payment = new Payment;
    $payment->payment_method_id = DB::table('payment_methods')->insertGetId(['name' => 'OTC']);
    $payment->amount = 499.50;
    $reservation->payments()->save($payment);
    $payment->status = 'verified';
    $payment->save();
    $refund = $payment->replicate();
    $refund->type = 'refund';
    $refund->save();

    $reservation->status = 'cancelled';
    $reservation->save();
    $reservation->confirmation_remarks = 'Refund recorded';
    $reservation->save();

    $this->get(route('admin.dashboard'))->assertOk()
        ->assertSee("Reservation #{$reservation->id} was booked.")
        ->assertSee("Reservation #{$reservation->id} was cancelled.")
        ->assertSee("Payment #{$payment->id} for reservation #{$reservation->id} needs verification.");
    $this->assertDatabaseCount('admin_notifications', 3);
});
