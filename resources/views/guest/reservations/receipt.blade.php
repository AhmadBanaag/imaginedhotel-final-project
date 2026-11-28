@extends('layouts.hotel')
@section('content')
<section class="max-w-4xl mx-auto p-8">
    <a href="{{ route('guest.reservations.show', $booking) }}" class="text-indigo-700">← Back to reservation</a>
    <h1 class="text-2xl font-bold my-4">Payment receipt</h1>
    <dl class="bg-white border rounded-xl p-6 grid grid-cols-2 gap-3">
        <dt>Reservation</dt><dd>{{ $booking->reservation_code }}</dd>
        <dt>Guest</dt><dd>{{ $booking->guest->first_name }} {{ $booking->guest->last_name }}</dd>
        <dt>Room</dt><dd>{{ $booking->room->room_number }}</dd>
        <dt>Stay dates</dt><dd>{{ $booking->check_in_date }} → {{ $booking->check_out_date }}</dd>
        <dt>Stay total</dt><dd>₱{{ number_format($booking->total_amount, 2) }}</dd>
        @foreach ($payments as $payment)
            <dt>Payment #{{ $payment->id }} · {{ $payment->paymentMethod->name }}</dt>
            <dd>₱{{ number_format($payment->amount, 2) }} · Verified</dd>
        @endforeach
        <dt>Total paid</dt><dd>₱{{ number_format($payments->sum('amount'), 2) }}</dd>
        <dt>Remaining balance</dt><dd>₱{{ number_format($booking->total_amount - $payments->sum('amount'), 2) }}</dd>
    </dl>
</section>
@endsection
