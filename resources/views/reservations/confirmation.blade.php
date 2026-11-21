@extends('layouts.hotel')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Success Banner -->
    <div class="text-center mb-8">
        <div class="w-16 h-16 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center text-3xl mx-auto mb-4 shadow-xs">
            <i class="ri-checkbox-circle-line"></i>
        </div>
        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Reservation Confirmed!</h1>
        <p class="text-sm text-slate-500 mt-1">
            Thank you! Your booking has been recorded. Please save your unique reservation code or print your official E-Receipt.
        </p>
    </div>

    <!-- Official Printable E-Receipt Card -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-xl overflow-hidden mb-8" id="printableReceipt">
        <!-- Receipt Top Header -->
        <div class="bg-slate-900 text-white p-6 sm:p-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <div class="flex items-center gap-2">
                    <div class="w-9 h-9 rounded-xl bg-indigo-600 text-white flex items-center justify-center font-bold text-lg">IH</div>
                    <span class="text-xl font-bold tracking-tight">Imagined<span class="text-indigo-400">Hotel</span></span>
                </div>
                <p class="text-xs text-slate-400 mt-1">Official Hotel Electronic Receipt &amp; Booking Record</p>
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
                    <span class="text-slate-400 block mb-0.5">Contact Email</span>
                    <strong class="text-slate-900 font-semibold">{{ request('email', 'guest@example.com') }}</strong>
                </div>
                <div>
                    <span class="text-slate-400 block mb-0.5">Stay Dates</span>
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

            <!-- Policy & Notes -->
            <div class="text-[11px] text-slate-500 space-y-1 bg-amber-50/50 p-4 rounded-xl border border-amber-100">
                <p><strong>Check-in Time:</strong> 2:00 PM | <strong>Check-out Time:</strong> 12:00 PM</p>
                <p><strong>Cancellation Terms:</strong> In accordance with hotel policy, cancellations incur a 20% processing deduction from the deposited amount.</p>
                <p><strong>Location:</strong> ImaginedHotel Reception, UICTO, USM, Kabacan.</p>
            </div>
        </div>

        <!-- Receipt Footer Buttons -->
        <div class="bg-slate-50 px-6 sm:px-8 py-4 border-t border-slate-100 flex flex-wrap justify-between items-center gap-3">
            <span class="text-xs text-slate-500">Issued on {{ date('F d, Y h:i A') }}</span>
            <div class="flex gap-2">
                <button onclick="window.print()" class="px-4 py-2 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-semibold flex items-center gap-1.5 transition">
                    <i class="ri-printer-line"></i> Print E-Receipt
                </button>
                <a href="{{ route('landing') }}" class="px-4 py-2 rounded-xl bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 text-xs font-semibold transition">
                    Back to Hotel
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
