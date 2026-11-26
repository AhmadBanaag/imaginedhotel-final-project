<?php

namespace App\Services;

use Carbon\CarbonImmutable;
use InvalidArgumentException;

class ReservationService
{
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