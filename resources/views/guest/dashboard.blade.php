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

    <!-- Active / Upcoming Stay Card -->
    <div class="bg-linear-to-tr from-slate-900 to-indigo-950 rounded-3xl text-white p-6 sm:p-8 shadow-xl mb-8 relative overflow-hidden">
        <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div class="space-y-3">
                <div class="flex items-center gap-2">
                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-500 text-white">
                        Upcoming Active Stay
                    </span>
                    <span class="text-xs text-indigo-200 font-mono">Code: IH-2026-8492</span>
                </div>
                <h3 class="text-2xl font-bold tracking-tight">Double-bed Room (Unit 205)</h3>
                <div class="flex flex-wrap gap-4 text-xs text-slate-300">
                    <span><i class="ri-calendar-line text-amber-400 mr-1"></i> {{ date('M d, Y') }} &rarr; {{ date('M d, Y', strtotime('+1 day')) }}</span>
                    <span><i class="ri-wallet-line text-blue-400 mr-1"></i> 50% OTC Deposit Paid (₱1,000)</span>
                    <span><i class="ri-map-pin-line text-rose-400 mr-1"></i> UICTO, USM, Kabacan</span>
                </div>
            </div>
            <div class="flex flex-col sm:flex-row gap-2 shrink-0">
                <a href="{{ route('guest.reservations.show', 1) }}" class="px-4 py-2.5 rounded-xl bg-white text-slate-900 text-xs font-bold hover:bg-slate-100 transition text-center">
                    Manage Booking
                </a>
                <a href="{{ route('reservations.confirmation') }}" class="px-4 py-2.5 rounded-xl bg-indigo-600/80 hover:bg-indigo-600 text-white text-xs font-semibold transition text-center border border-indigo-500">
                    Download E-Receipt
                </a>
            </div>
        </div>
    </div>

    <!-- Quick Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-2xs">
            <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl mb-3">
                <i class="ri-hotel-bed-line"></i>
            </div>
            <div class="text-2xl font-bold text-slate-900">1</div>
            <span class="text-xs text-slate-500 font-medium">Active / Upcoming Reservations</span>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-2xs">
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl mb-3">
                <i class="ri-checkbox-circle-line"></i>
            </div>
            <div class="text-2xl font-bold text-slate-900">2</div>
            <span class="text-xs text-slate-500 font-medium">Completed Past Stays</span>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-2xs">
            <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl mb-3">
                <i class="ri-user-settings-line"></i>
            </div>
            <div class="text-sm font-bold text-slate-900">Verified Account</div>
            <span class="text-xs text-slate-500 font-medium">Profile details &amp; password</span>
            <a href="{{ route('profile.edit') }}" class="text-xs text-indigo-600 hover:underline block mt-2">Edit Account &rarr;</a>
        </div>
    </div>
</div>
@endsection
