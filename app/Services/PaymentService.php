<?php

namespace App\Services;

class PaymentService
{
    public function calculateOtcDepositInCentavos(int $totalInCentavos): int
    {
        return intdiv($totalInCentavos + 1, 2);
    }
}
