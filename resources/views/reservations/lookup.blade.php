@extends('layouts.hotel')

@section('lookup')
@include('components.navbar2')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 pt-25" x-data="{
    searchDone: {{ request()->has('code') ? 'true' : 'false' }},
    showCancelModal: false,
    showReceiptModal: false
}">
    <!-- Header -->
    <div class="text-center mb-8">  
        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Find My ImaginedHotel Reservation</h1>
        <p class="text-sm text-slate-500 mt-1">Booked without an account? Enter your unique Reservation Code and Email below.</p>
    </div>

    <!-- Search Form Card -->
    <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-2xs mb-8">
        <form action="{{ route('reservations.lookup') }}" method="GET" class="space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Reservation Code</label>
                    <input type="text" name="code" value="{{ request('code', 'IH-2026-8492') }}" placeholder="e.g. IH-2026-8492" required class="w-full text-sm font-mono rounded-xl border-slate-200 focus:ring-indigo-500 focus:border-indigo-500 uppercase">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Guest Email Address</label>
                    <input type="email" name="email" value="{{ request('email', 'guest@example.com') }}" placeholder="e.g. guest@example.com" required class="w-full text-sm rounded-xl border-slate-200 focus:ring-indigo-500 focus:border-indigo-500">
                </div>
            </div>
            <button type="submit" class="w-full py-3 bg-[#EDC92C] hover:bg-[#06923E] text-white font-semibold rounded-xl text-sm transition flex items-center justify-center gap-2">
                <i class="ri-search-line"></i> Look Up Booking
            </button>
        </form>
    </div>

    <!-- Booking Details Result Card (Shown when searched) -->
    <div x-show="searchDone" class="bg-white rounded-3xl border border-slate-200 shadow-md p-6 sm:p-8 space-y-6 mb-8">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2 pb-4 border-b border-slate-100">
            <div>
                <span class="text-xs text-slate-400">Reservation Reference</span>
                <h3 class="text-xl font-mono font-bold text-slate-900">IH-2026-8492</h3>
            </div>
            <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">
                Confirmed Booking
            </span>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-xs">
            <div>
                <span class="text-slate-400 block mb-0.5">Guest Name</span>
                <strong class="text-slate-800 font-semibold">Juan Dela Cruz</strong>
            </div>
            <div>
                <span class="text-slate-400 block mb-0.5">Room Category</span>
                <strong class="text-slate-800 font-semibold">Double-bed (Room 205)</strong>
            </div>
            <div>
                <span class="text-slate-400 block mb-0.5">Check-in</span>
                <strong class="text-slate-800 font-semibold">{{ date('M d, Y') }} (2:00 PM)</strong>
            </div>
            <div>
                <span class="text-slate-400 block mb-0.5">Check-out</span>
                <strong class="text-slate-800 font-semibold">{{ date('M d, Y', strtotime('+1 day')) }} (12:00 PM)</strong>
            </div>
        </div>

        <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100 text-xs space-y-1">
            <div class="flex justify-between">
                <span class="text-slate-500">Payment Status:</span>
                <span class="font-semibold text-slate-900">50% OTC Deposit Paid (₱1,000)</span>
            </div>
            <div class="flex justify-between">
                <span class="text-slate-500">Remaining Balance:</span>
                <span class="font-semibold text-slate-900">₱999 due at reception</span>
            </div>
        </div>

        <!-- Action Row -->
        <div class="pt-4 border-t border-slate-100 flex flex-wrap justify-between items-center gap-3">
            <button @click="showReceiptModal = true" class="px-4 py-2 rounded-xl bg-[#EDC92C] text-white text-xs font-semibold hover:bg-[#06923E] transition">
                <i class="ri-file-text-line mr-1"></i> View E-Receipt
            </button>
            <button @click="showCancelModal = true" class="px-4 py-2 rounded-xl bg-rose-50 text-rose-700 hover:bg-rose-100 text-xs font-semibold border border-rose-200 transition">
                <i class="ri-close-circle-line mr-1"></i> Request Cancellation
            </button>
        </div>
    </div>  

    <!-- Receipt Modal -->
    <div x-show="showReceiptModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 p-4">
        <div @click.outside="showReceiptModal = false" class="bg-white rounded-3xl shadow-xl overflow-hidden mb-8">
            <!-- Receipt Top Header -->
            <div class="bg-slate-900 text-white p-6 sm:p-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <div class="flex items-center">
                        <a href="{{ route('landing') }}" class="flex items-center gap-2 group">
                            <i class="ri-hotel-line text-4xl text-[#EDC92C]"></i>
                            <div>
                                <span class="text-white text-xl font-bold tracking-tight text-slate-900">ImaginedHotel</span>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="text-left sm:text-right">
                    <span class="text-[10px] uppercase font-bold tracking-wider text-slate-400 block">Reservation Code</span>
                    <span class="text-xl font-mono font-bold text-amber-400 tracking-wider">IH-2026-8492</span>
                </div>
            </div>

            <!-- Receipt Body Details -->
            <div class="p-6 sm:p-8 space-y-6">
                <!-- Guest & Booking Summary Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 pb-6 border-b border-slate-100 text-xs">
                    <div>
                        <span class="text-slate-400 block mb-0.5">Guest Name</span>
                        <strong class="text-slate-900 font-semibold">{{ request('first_name', 'Juan') }} {{ request('last_name', 'Dela Cruz') }}</strong>
                    </div>
                    <div>
                        <span class="text-slate-400 block mb-0.5">Email</span>
                        <strong class="text-slate-900 font-semibold">{{ request('email', 'guest@example.com') }}</strong>
                    </div>
                    <div>
                        <span class="text-slate-400 block mb-0.5">Check-in and Check-out dates</span>
                        <strong class="text-slate-900 font-semibold">{{ request('check_in', date('M d, Y')) }} &rarr; {{ request('check_out', date('M d, Y', strtotime('+1 day'))) }}</strong>
                    </div>
                    <div>
                        <span class="text-slate-400 block mb-0.5">Assigned Room</span>
                        <strong class="text-indigo-600 font-semibold uppercase">{{ request('room_type', 'Single') }} Room (Unit 104)</strong>
                    </div>
                </div>

                <!-- Payment Breakdown Table -->
                <div>
                    <h4 class="text-xs font-bold uppercase text-slate-500 mb-3 tracking-wider">Payment Breakdown</h4>
                    <div class="bg-slate-50 rounded-xl p-4 border border-slate-100 space-y-2 text-xs">
                        <div class="flex justify-between">
                            <span class="text-slate-600">Room Rate (1 Night)</span>
                            <span class="font-semibold text-slate-900">
                                ₱{{ request('room_type') == 'superior' ? '4,999' : (request('room_type') == 'family' ? '2,999' : (request('room_type') == 'double' ? '1,999' : '999')) }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-600">Selected Payment Method</span>
                            <span class="font-semibold text-slate-900 uppercase">{{ request('payment_method') == 'ewallet' ? 'E-Wallet QR (Verified)' : 'Over The Counter (50% Deposit)' }}</span>
                        </div>
                        <div class="flex justify-between text-emerald-700 font-semibold">
                            <span>Amount Paid / Deposited</span>
                            <span>
                                ₱{{ request('payment_method') == 'ewallet' ? (request('room_type') == 'superior' ? '4,999' : (request('room_type') == 'family' ? '2,999' : (request('room_type') == 'double' ? '1,999' : '999'))) : (request('room_type') == 'superior' ? '2,500' : (request('room_type') == 'family' ? '1,500' : (request('room_type') == 'double' ? '1,000' : '500'))) }}
                            </span>
                        </div>
                        <div class="flex justify-between text-slate-600">
                            <span>Balance Payable Upon Check-in</span>
                            <span>
                                ₱{{ request('payment_method') == 'ewallet' ? '0.00' : (request('room_type') == 'superior' ? '2,499' : (request('room_type') == 'family' ? '1,499' : (request('room_type') == 'double' ? '999' : '499'))) }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="flex gap-2 pt-2">
                    <button @click="showReceiptModal = false" class="flex-1 py-2.5 rounded-xl bg-[#EDC92C] border border-slate-200 text-white text-xs font-semibold hover:bg-[#06923E]">OK</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Cancellation Confirmation Modal -->
    <div x-show="showCancelModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 p-4">
        <div @click.outside="showCancelModal = false" class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl space-y-4">
            <div class="w-12 h-12 bg-rose-100 text-rose-600 rounded-xl flex items-center justify-center text-2xl">
                <i class="ri-alert-line"></i>
            </div>
            <h3 class="text-lg font-bold text-slate-900">Confirm Booking Cancellation?</h3>
            <p class="text-xs text-slate-600 leading-relaxed">
                As stated in our hotel policies, cancelling your reservation incurs a <strong>20% cancellation deduction</strong> from your deposited amount.
            </p>
            <div class="bg-slate-50 p-3 rounded-xl border border-slate-200 text-xs space-y-1">
                <div class="flex justify-between"><span>Deposit Paid:</span> <strong>₱1,000</strong></div>
                <div class="flex justify-between text-rose-600"><span>20% Cancellation Fee:</span> <strong>-₱200</strong></div>
                <hr class="border-slate-200 my-1">
                <div class="flex justify-between text-emerald-700 font-bold"><span>Refund Amount:</span> <strong>₱800</strong></div>
            </div>
            <p class="text-[11px] text-slate-400">Cancelling will immediately release Room 205 back to available for other guests.</p>
            <div class="flex gap-2 pt-2">
                <button @click="showCancelModal = false" class="flex-1 py-2.5 rounded-xl border border-slate-200 text-slate-700 text-xs font-semibold hover:bg-slate-50">Keep Booking</button>
                <button @click="showCancelModal = false; alert('Cancellation processed. Room released. Refund of ₱800 logged.')" class="flex-1 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-semibold">Yes, Cancel Booking</button>
            </div>
        </div>
    </div>
</div>
@endsection
