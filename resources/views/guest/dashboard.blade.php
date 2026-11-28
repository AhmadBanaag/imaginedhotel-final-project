@extends('layouts.hotel')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <!-- Welcome Header -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-2xs mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="inline-flex items-center gap-1.5 px-3 py-0.5 rounded-full bg-indigo-50 text-indigo-700 text-xs font-semibold mb-2">
                <i class="ri-user-star-line"></i> Registered Guest Portal
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                Welcome, {{ Auth::check() ? Auth::user()->name : 'Guest Traveler' }}!
            </h1>
            <p class="text-sm text-slate-500 mt-1">Manage your active stays, download official E-receipts, or book your next room.</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('rooms.index') }}" class="px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-xs shadow-2xs transition flex items-center gap-1.5">
                <i class="ri-add-line"></i> Book Another Room
            </a>
            <a href="{{ route('guest.reservations.index') }}" class="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs transition">
                View All Bookings
            </a>
        </div>
    </div>

    <section class="bg-white border rounded-xl p-6">
        <h2 class="font-bold">Latest reservation</h2>
        @if ($latest)
            <a class="text-indigo-700 underline" href="{{ route('guest.reservations.show', $latest) }}">{{ $latest->reservation_code }} · {{ $latest->room->room_number }}</a>
        @else
            <p>No reservations yet.</p>
        @endif
    </section>
    <a href="{{ route('profile.edit') }}">Edit account</a>
</div>
@endsection
