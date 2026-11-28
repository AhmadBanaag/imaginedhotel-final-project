<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\Reservation;

class PaymentService
{
    public function recordPending(Reservation $reservation, string $method, ?string $reference): void
    {
        $otc = $method === 'otc';
        $paymentMethod = PaymentMethod::firstOrCreate(
            ['name' => $otc ? 'OTC' : 'E-Wallet'],
            ['down_payment_percent' => $otc ? 50 : 100]
        );
        $total = (int) round($reservation->total_amount * 100);
        $payment = new Payment;
        $payment->paymentMethod()->associate($paymentMethod);
        $payment->amount = ($otc ? $this->calculateOtcDepositInCentavos($total) : $total) / 100;
        $payment->reference_number = $otc ? null : $reference;
        $reservation->payments()->save($payment);
    }

    public function calculateOtcDepositInCentavos(int $totalInCentavos): int
    {
        return intdiv($totalInCentavos + 1, 2);
    }
    public function calculateRefundInCentavos(int $paidInCentavos): int
    {
        return intdiv($paidInCentavos * 80 + 50, 100);
    }
}

