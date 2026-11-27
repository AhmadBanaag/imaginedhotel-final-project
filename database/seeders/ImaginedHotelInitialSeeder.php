<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImaginedHotelInitialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('user_roles')->insert([
            ['role_name' => 'admin', 'created_at' => now(), 'updated_at' => now()],
            ['role_name' => 'guest', 'created_at' => now(), 'updated_at' => now()],
            ['role_name' => 'account_user', 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('room_types')->insert([
            ['name' => 'Single-bed-room', 'PricePerNight' => 999.00, 'maxGuest' => 1],
            ['name' => 'Double-bed-room', 'PricePerNight' => 1999.00, 'maxGuest' => 2],
            ['name' => 'Family-Room', 'PricePerNight' => 2999.00, 'maxGuest' => 4],
            ['name' => 'Deluxe-Room', 'PricePerNight' => 4999.00, 'maxGuest' => 6],

        ]);
        // sAMPLE Rooms for testing
        DB::table('rooms')->insert([
            ['room_type_id' => 1, 'room_number' => 'Room 101', 'status' => 'available', 'created_at' => now(), 'updated_at' => now()],
            ['room_type_id' => 1, 'room_number' => 'Room 102', 'status' => 'booked', 'created_at' => now(), 'updated_at' => now()],
            ['room_type_id' => 2, 'room_number' => 'Room 201', 'status' => 'available', 'created_at' => now(), 'updated_at' => now()],
            ['room_type_id' => 3, 'room_number' => 'Room 301', 'status' => 'unavailable', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
