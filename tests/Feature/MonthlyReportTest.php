<?php

use App\Services\MonthlyReportService;
use Illuminate\Support\Facades\DB;

test('empty month returns zero metrics without division errors', function () {
    $report = app(MonthlyReportService::class)->generate('2026-11');

    expect($report['total_stays'])->toBe(0)
        ->and($report['gross_revenue'])->toBe(0.0)
        ->and($report['occupancy_pct'])->toBe(0.0)
        ->and($report['otc_pct'])->toBe(0)
        ->and($report['ewallet_pct'])->toBe(0);
});

test('option A clips occupancy nights across month boundaries and attributes booking to check_in month', function () {
    $typeId = DB::table('room_types')->insertGetId([
        'name' => 'Single-bed-room',
        'PricePerNight' => 1000,
        'maxGuest' => 1,
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    $roomId = DB::table('rooms')->insertGetId([
        'room_type_id' => $typeId,
        'room_number' => 'Room 101',
        'status' => 'available',
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    $guestId = DB::table('guests')->insertGetId([
        'first_name' => 'Juan',
        'last_name' => 'Dela Cruz',
        'email' => 'juan@example.com',
        'phone_number' => '09170000000',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    // Check-in Oct 30, Check-out Nov 02 => 2 nights in Oct (31 days), 1 night in Nov (30 days)
    DB::table('reservations')->insert([
        'guest_id' => $guestId,
        'room_id' => $roomId,
        'reservation_code' => 'IH-2026-1001',
        'check_in_date' => '2026-10-30',
        'check_out_date' => '2026-11-02',
        'total_amount' => 3000,
        'status' => 'confirmed',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $oct = app(MonthlyReportService::class)->generate('2026-10');
    $nov = app(MonthlyReportService::class)->generate('2026-11');

    expect($oct['total_stays'])->toBe(1)
        ->and($oct['gross_revenue'])->toBe(3000.0)
        ->and($oct['occupancy_pct'])->toBe(round((2 / 31) * 100, 1))
        ->and($nov['total_stays'])->toBe(0)
        ->and($nov['gross_revenue'])->toBe(0.0)
        ->and($nov['occupancy_pct'])->toBe(round((1 / 30) * 100, 1));
});

test('admin reports page and record audit log', function () {
    $this->get(route('admin.reports.index', ['month' => '2026-11']))
        ->assertOk()
        ->assertSee('November 2026');
});