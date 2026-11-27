<?php

use App\Models\Guest;
use App\Models\Payment;
use App\Models\Reservation;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

it('shows saved bookings, pending payments and cancellations once in the bell', function () {
    // Minimal room fixture while the inventory migrations live on the room branch.
    Schema::create('rooms', function (Blueprint $table) {
        $table->id('room_id');
    });
    $room = DB::table('rooms')->insertGetId(['room_id' => 1]);
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
