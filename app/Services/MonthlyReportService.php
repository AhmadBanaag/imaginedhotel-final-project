<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\RoomType;
use Carbon\CarbonImmutable;

class MonthlyReportService
{
    public const ACTIVE_STATUSES = [
        'pending',
        'confirmed',
        'checked_in',
        'checked_out',
        'overstay',
    ];

    public function generate(string $month): array
    {
        $monthStart = CarbonImmutable::createFromFormat('Y-m', $month)->startOfMonth();
        $nextMonthStart = $monthStart->addMonth();
        $prevMonthStart = $monthStart->subMonth();

        // 1. Active bookings attributed to check_in_date in the selected month
        $monthBookings = Reservation::query()
            ->with(['room.roomType'])
            ->whereIn('status', self::ACTIVE_STATUSES)
            ->where('check_in_date', '>=', $monthStart->toDateString())
            ->where('check_in_date', '<', $nextMonthStart->toDateString())
            ->orderBy('check_in_date')
            ->get();

        $prevMonthBookingCount = Reservation::query()
            ->whereIn('status', self::ACTIVE_STATUSES)
            ->where('check_in_date', '>=', $prevMonthStart->toDateString())
            ->where('check_in_date', '<', $monthStart->toDateString())
            ->count();

        $totalStays = $monthBookings->count();
        $grossRevenue = (float) $monthBookings->sum('total_amount');

        // 2. Option A Occupancy: clip overlapping stays to [monthStart, nextMonthStart)
        $overlappingStays = Reservation::query()
            ->whereIn('status', self::ACTIVE_STATUSES)
            ->where('check_in_date', '<', $nextMonthStart->toDateString())
            ->where('check_out_date', '>', $monthStart->toDateString())
            ->get(['check_in_date', 'check_out_date']);

        $occupiedNights = $overlappingStays->sum(fn ($stay) => $this->clippedNights(
            CarbonImmutable::parse($stay->check_in_date)->startOfDay(),
            CarbonImmutable::parse($stay->check_out_date)->startOfDay(),
            $monthStart,
            $nextMonthStart
        ));

        $totalUnits = Room::count();
        $capacityNights = $totalUnits * $monthStart->daysInMonth;
        $occupancyPct = $capacityNights > 0
            ? round(($occupiedNights / $capacityNights) * 100, 1)
            : 0.0;

        // 3. Cancellations & retained 20% fees
        $cancelledReservations = Reservation::query()
            ->with('payments')
            ->where('status', 'cancelled')
            ->where('check_in_date', '>=', $monthStart->toDateString())
            ->where('check_in_date', '<', $nextMonthStart->toDateString())
            ->get();

        $cancellationsCount = $cancelledReservations->count();
        $retainedFees = $cancelledReservations->sum(function ($reservation) {
            $paid = $reservation->payments
                ->where('status', 'verified')
                ->where('type', '!=', 'refund')
                ->sum('amount');
            $refunded = $reservation->payments
                ->where('type', 'refund')
                ->sum('amount');

            return max(0.0, (float) $paid - (float) $refunded);
        });

        // 4. OTC vs. E-Wallet revenue split (verified non-refund payments)
        $monthPayments = Payment::query()
            ->with('paymentMethod')
            ->whereIn('reservation_id', $monthBookings->pluck('id'))
            ->where('status', 'verified')
            ->where('type', '!=', 'refund')
            ->get();

        $otcRevenue = (float) $monthPayments
            ->filter(fn ($p) => strtolower($p->paymentMethod?->name ?? '') === 'otc')
            ->sum('amount');

        $ewalletRevenue = (float) $monthPayments
            ->filter(fn ($p) => strtolower($p->paymentMethod?->name ?? '') === 'ewallet')
            ->sum('amount');

        $channelTotal = $otcRevenue + $ewalletRevenue;
        $otcPct = $channelTotal > 0 ? (int) round(($otcRevenue / $channelTotal) * 100) : 0;
        $ewalletPct = $channelTotal > 0 ? 100 - $otcPct : 0;

        // 5. Category breakdown across all RoomTypes
        $bookingsByType = $monthBookings->groupBy(fn ($r) => $r->room?->room_type_id);
        $categories = RoomType::query()
            ->withCount('rooms')
            ->orderBy('PricePerNight')
            ->get()
            ->map(function (RoomType $type) use ($bookingsByType, $totalStays) {
                $group = $bookingsByType->get($type->room_type_id, collect());
                $stays = $group->count();
                $revenue = (float) $group->sum('total_amount');

                return [
                    'name'      => $type->name,
                    'units'     => $type->rooms_count,
                    'rate'      => (float) $type->PricePerNight,
                    'stays'     => $stays,
                    'revenue'   => $revenue,
                    'share_pct' => $totalStays > 0 ? round(($stays / $totalStays) * 100, 1) : 0.0,
                    'is_vip'    => str_contains(strtolower($type->name), 'suite')
                        || str_contains(strtolower($type->name), 'superior'),
                ];
            });

        return [
            'month'         => $month,
            'label'         => $monthStart->format('F Y'),
            'trend'         => $this->formatTrend($totalStays, $prevMonthBookingCount),
            'total_stays'   => $totalStays,
            'gross_revenue' => $grossRevenue,
            'total_units'   => $totalUnits,
            'occupancy_pct' => $occupancyPct,
            'cancellations' => $cancellationsCount,
            'retained_fees' => $retainedFees,
            'otc_revenue'   => $otcRevenue,
            'ewallet_revenue' => $ewalletRevenue,
            'otc_pct'       => $otcPct,
            'ewallet_pct'   => $ewalletPct,
            'categories'    => $categories,
        ];
    }

    private function clippedNights(
        CarbonImmutable $checkIn,
        CarbonImmutable $checkOut,
        CarbonImmutable $monthStart,
        CarbonImmutable $nextMonthStart
    ): int {
        $from = $checkIn->greaterThan($monthStart) ? $checkIn : $monthStart;
        $to = $checkOut->lessThan($nextMonthStart) ? $checkOut : $nextMonthStart;

        return $to->greaterThan($from) ? (int) $from->diffInDays($to) : 0;
    }

    private function formatTrend(int $current, int $previous): string
    {
        if ($previous === 0) {
            return $current > 0 ? 'Baseline Period' : 'No activity yet';
        }

        $delta = (($current - $previous) / $previous) * 100;
        $prefix = $delta >= 0 ? '+' : '';

        return $prefix . number_format($delta, 1) . '% vs previous month';
    }
}