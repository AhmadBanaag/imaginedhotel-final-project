<?php

namespace App\Services;

class PaymentService
{
    public function calculateOtcDepositInCentavos(int $totalInCentavos): int
    {
        return intdiv($totalInCentavos + 1, 2);
    }
    public function calculateRefundInCentavos(int $paidInCentavos): int
    {
        return intdiv($paidInCentavos * 80 + 50, 100);
    }
}

