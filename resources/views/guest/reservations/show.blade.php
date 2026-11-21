@extends('layouts.hotel')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10" x-data="{ showCancelModal: false }">
    <div class="mb-6">
        <a href="{{ route('guest.reservations.index') }}" class="text-xs font-semibold text-indigo-600 hover:underline inline-flex items-center gap-1 mb-2">
            &larr; Back to My Reservations
        </a>
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Booking Details &bull; IH-2026-8492</h1>
                <p class="text-xs text-slate-500 mt-0.5">Recorded on {{ date('F d, Y') }} via ImaginedHotel Reservation Engine</p>
            </div>
            <div>
                <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">
                    Confirmed Stay
                </span>
            </div>
        </div>
    </div>

    <!-- Booking Card -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 sm:p-8 space-y-6 mb-6">
        <!-- Room Info -->
        <div class="flex flex-col sm:flex-row gap-6 pb-6 border-b border-slate-100">
            <div class="w-full sm:w-48 h-32 bg-slate-900 rounded-2xl flex items-center justify-center text-white shrink-0">
                <i class="ri-hotel-bed-fill text-4xl text-indigo-400"></i>
            </div>
            <div class="space-y-1.5 flex-grow">
                <h3 class="text-xl font-bold text-slate-900">Double-bed Room (Unit 205)</h3>
                <p class="text-xs text-slate-500">Double bed, Storage, Air-conditioned, Free WiFi, Flat Screen TV, Bathroom with Shower &amp; Toiletries.</p>
                <div class="pt-2 flex flex-wrap gap-4 text-xs">
                    <div><span class="text-slate-400 block">Check-in Date:</span> <strong class="text-slate-800">{{ date('M d, Y') }} (2:00 PM)</strong></div>
                    <div><span class="text-slate-400 block">Check-out Date:</span> <strong class="text-slate-800">{{ date('M d, Y', strtotime('+1 day')) }} (12:00 PM)</strong></div>
                    <div><span class="text-slate-400 block">Nights:</span> <strong class="text-slate-800">1 Night</strong></div>
                </div>
            </div>
        </div>

        <!-- Payment Breakdown -->
        <div>
            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-3">Billing &amp; Deposit Summary</h4>
            <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100 space-y-2 text-xs">
                <div class="flex justify-between">
                    <span class="text-slate-600">Total Room Charge (1 Night @ ₱1,999)</span>
                    <span class="font-bold text-slate-900">₱1,999.00</span>
                </div>
                <div class="flex justify-between text-emerald-700 font-semibold">
                    <span>50% OTC Deposit Paid</span>
                    <span>₱1,000.00</span>
                </div>
                <div class="flex justify-between text-slate-600">
                    <span>Remaining Balance Payable at Check-in</span>
                    <span>₱999.00</span>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="pt-4 border-t border-slate-100 flex flex-wrap justify-between items-center gap-3">
            <a href="{{ route('reservations.confirmation') }}" class="px-4 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-semibold transition inline-flex items-center gap-1.5">
                <i class="ri-printer-line"></i> View E-Receipt
            </a>
            <button @click="showCancelModal = true" class="px-4 py-2.5 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-700 text-xs font-semibold border border-rose-200 transition">
                <i class="ri-close-circle-line mr-1"></i> Cancel Reservation
            </button>
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
                <div class="flex justify-between text-emerald-700 font-bold"><span>Refund Amount (80%):</span> <strong>₱800</strong></div>
            </div>
            <p class="text-[11px] text-slate-400">Cancelling will immediately release Unit 205 back to available for other guests.</p>
            <div class="flex gap-2 pt-2">
                <button @click="showCancelModal = false" class="flex-1 py-2.5 rounded-xl border border-slate-200 text-slate-700 text-xs font-semibold hover:bg-slate-50">Keep Booking</button>
                <button @click="showCancelModal = false; alert('Cancellation processed. Room released. Refund of ₱800 logged.')" class="flex-1 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-semibold">Yes, Cancel &amp; Refund 80%</button>
            </div>
        </div>
    </div>
</div>
@endsection
