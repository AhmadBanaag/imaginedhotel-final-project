@extends('layouts.hotel')
@section('content')
<section class="max-w-4xl mx-auto p-8">
    <a href="{{ route('guest.reservations.index') }}" class="text-indigo-700">← Back to My Reservations</a>
    <h1 class="text-2xl font-bold my-4">Reservation {{ $booking->reservation_code }}</h1>
    <dl class="bg-white border rounded-xl p-6 grid grid-cols-2 gap-3">
        <dt>Guest</dt><dd>{{ $booking->guest->first_name }} {{ $booking->guest->last_name }}</dd>
        <dt>Room</dt><dd>{{ $booking->room->room_number }} · {{ $booking->room->roomType->name }}</dd>
        <dt>Check-in</dt><dd>{{ $booking->check_in_date }}</dd>
        <dt>Check-out</dt><dd>{{ $booking->check_out_date }}</dd>
        <dt>Stay total</dt><dd>₱{{ number_format($booking->total_amount, 2) }}</dd>
        <dt>Status</dt><dd>{{ ucfirst($booking->status) }}</dd>
        @forelse ($booking->payments()->with('paymentMethod')->get() as $payment)
            <dt>{{ ucfirst($payment->type) }} · {{ $payment->paymentMethod->name }}</dt>
            <dd>₱{{ number_format($payment->amount, 2) }} · {{ ucfirst($payment->status) }}</dd>
        @empty
            <dt>Payment</dt><dd>No payment recorded</dd>
        @endforelse
    </dl>
    @if ($booking->payments()->where('type', 'payment')->where('status', 'verified')->exists())
        <a class="inline-block mt-4 rounded-lg bg-emerald-700 px-4 py-2 text-white" href="{{ route('guest.reservations.receipt', $booking) }}">View receipt</a>
    @endif
</section>
@endsection
