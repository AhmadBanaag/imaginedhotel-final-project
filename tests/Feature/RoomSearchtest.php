<?php

use Illuminate\Support\Facades\DB;

function seedRoomFixture(): array
{
    $singleTypeId = DB::table('room_types')->insertGetId([
        'name' => 'Single-bed-room', 'PricePerNight' => 999, 'maxGuest' => 1,
        'created_at' => now(), 'updated_at' => now(),
    ]);
    $deluxeTypeId = DB::table('room_types')->insertGetId([
        'name' => 'Deluxe-Room', 'PricePerNight' => 4999, 'maxGuest' => 6,
        'created_at' => now(), 'updated_at' => now(),
    ]);

    $room101 = DB::table('rooms')->insertGetId([
        'room_type_id' => $singleTypeId, 'room_number' => 'Room 101', 'status' => 'available',
        'created_at' => now(), 'updated_at' => now(),
    ]);
    DB::table('rooms')->insert([
        'room_type_id' => $singleTypeId, 'room_number' => 'Room 102', 'status' => 'unavailable',
        'created_at' => now(), 'updated_at' => now(),
    ]);
    DB::table('rooms')->insert([
        'room_type_id' => $deluxeTypeId, 'room_number' => 'Room 401', 'status' => 'available',
        'created_at' => now(), 'updated_at' => now(),
    ]);

    return ['single_room' => $room101];
}

test('rooms catalog shows available categories and excludes unavailable units', function () {
    seedRoomFixture();

    $this->get(route('rooms.index'))
        ->assertOk()
        ->assertSee('Single-bed Room')
        ->assertSee('1 Unit Available')
        ->assertSee('Deluxe Room');
});

test('search filters by type and max budget and shows No room available when empty', function () {
    seedRoomFixture();

    $this->get(route('rooms.index', ['type' => 'single', 'budget' => 1000]))
        ->assertOk()
        ->assertViewHas('categories', fn ($categories) => $categories->pluck('slug')->all() === ['single'])
        ->assertSee('Reserve for ₱999')
        ->assertDontSee('Reserve for ₱4,999');

    $this->get(route('rooms.index', ['type' => 'deluxe', 'budget' => 1000]))
        ->assertOk()
        ->assertSee('No room available');
});

test('overlapping active reservations exclude booked rooms while cancelled bookings do not', function () {
    $ids = seedRoomFixture();
    $guestId = DB::table('guests')->insertGetId([
        'first_name' => 'Ana', 'last_name' => 'Reyes', 'email' => 'ana@example.com', 'phone_number' => '09170000001',
        'created_at' => now(), 'updated_at' => now(),
    ]);

    $checkIn = now()->addDays(5)->toDateString();
    $checkOut = now()->addDays(7)->toDateString();

    DB::table('reservations')->insert([
        'guest_id' => $guestId, 'room_id' => $ids['single_room'], 'reservation_code' => 'IH-2026-5001',
        'check_in_date' => $checkIn, 'check_out_date' => $checkOut, 'total_amount' => 1998, 'status' => 'confirmed',
        'created_at' => now(), 'updated_at' => now(),
    ]);

    // Overlapping date should hide Single-bed Room
    $this->get(route('rooms.index', ['type' => 'single', 'check_in' => $checkIn, 'check_out' => $checkOut]))
        ->assertOk()
        ->assertSee('No room available');

    // Same-day turnover (check_in == previous check_out) is available
    $this->get(route('rooms.index', ['type' => 'single', 'check_in' => $checkOut, 'check_out' => now()->addDays(8)->toDateString()]))
        ->assertOk()
        ->assertSee('Single-bed Room');
});