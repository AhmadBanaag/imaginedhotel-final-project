@extends('layouts.hotel')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">My Reservations &amp; Stay History</h1>
            <p class="text-sm text-slate-500 mt-1">Review your current, upcoming, and past hotel room bookings.</p>
        </div>
        <div>
            <a href="{{ route('rooms.index') }}" class="px-4 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold shadow-2xs transition inline-flex items-center gap-1.5">
                <i class="ri-add-line"></i> New Booking
            </a>
        </div>
    </div>  

    <!-- Reservations Table Card -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-2xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 uppercase tracking-wider font-semibold">
                        <th class="py-4 px-6">Booking Code</th>
                        <th class="py-4 px-6">Room Category</th>
                        <th class="py-4 px-6">Check-in / Check-out</th>
                        
                        <th class="py-4 px-6">Stay total</th>
                        <th class="py-4 px-6">Status</th>
                        <th class="py-4 px-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse ($bookings as $booking)
                        <tr>
                            <td class="py-4 px-6">{{ $booking->reservation_code }}</td>
                            <td>{{ $booking->room->roomType->name }} · {{ $booking->room->room_number }}</td>
                            <td>{{ $booking->check_in_date }} → {{ $booking->check_out_date }}</td>
                            <td>₱{{ number_format($booking->total_amount, 2) }}</td>
                            <td>{{ ucfirst($booking->status) }}</td>
                            <td class="text-right px-6"><a class="underline" href="{{ route('guest.reservations.show', $booking) }}">Details</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="p-6">No reservations yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
