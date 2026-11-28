<?php

use Database\Seeders\ImaginedHotelInitialSeeder;

it('saves a guest stay and rejects a second overlapping booking', function () {
    $this->seed(ImaginedHotelInitialSeeder::class);
    $data = [
        'room_type' => 'single', 'first_name' => 'Test', 'last_name' => 'Guest',
        'email' => 'guest@example.test', 'phone_number' => '09170000000',
        'check_in' => today()->addDay()->toDateString(), 'check_out' => today()->addDays(3)->toDateString(),
        'payment_method' => 'otc',
    ];
    $this->post(route('reservations.store'), $data)->assertSessionHas('booking_status');
    $this->assertDatabaseHas('reservations', ['room_id' => 1, 'total_amount' => 1998]);
    $this->post(route('reservations.store'), $data)->assertSessionHasErrors('room_type');
    $this->assertDatabaseCount('reservations', 1);
    $this->assertDatabaseCount('payments', 1);
    $this->assertDatabaseHas('payments', ['amount' => 999, 'status' => 'pending', 'paid_at' => null]);
    $this->assertDatabaseCount('admin_notifications', 2);
});

it('allows only staff to verify a pending deposit and records who confirmed it', function () {
    $this->seed(ImaginedHotelInitialSeeder::class);
    $this->post(route('reservations.store'), [
        'room_type' => 'double', 'first_name' => 'Test', 'last_name' => 'Guest',
        'email' => 'guest@example.test', 'phone_number' => '09170000000',
        'check_in' => today()->addDay()->toDateString(), 'check_out' => today()->addDays(2)->toDateString(),
        'payment_method' => 'otc',
    ])->assertSessionHasNoErrors();
    $payment = \App\Models\Payment::sole();
    $url = route('admin.payments.verify', $payment);
    $customer = \App\Models\User::factory()->create(['role_id' => 3]);
    $this->actingAs($customer)->patch($url)->assertForbidden();
    $staff = \App\Models\User::factory()->create(['role_id' => 1, 'is_active' => true]);
    $this->actingAs($staff)->get(route('admin.payments.index'))->assertOk()->assertSee('999.50');
    $this->patch($url)->assertRedirect(route('admin.payments.index'));
    $this->patch($url)->assertSessionHas('status', 'This payment is no longer pending.');
    expect($payment->refresh()->status)->toBe('verified');
    expect($payment->verified_by)->toBe($staff->id);
    expect($payment->paid_at)->not->toBeNull();
});
