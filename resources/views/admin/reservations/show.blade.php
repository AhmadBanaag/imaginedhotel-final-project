@extends('layouts.admin')

@section('page-title', 'Reservation Hub &bull; IH-2026-8492')
@section('page-subtitle', 'Front Desk operations: Check-in, Check-out, No-Show, Overstay, and Payment Verification')

@section('content')
<div class="space-y-6" x-data="{
    status: 'pending_checkin',
    remarks: '50% OTC deposit verified by receptionist.'
}">
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.reservations.index') }}" class="text-xs font-semibold text-indigo-600 hover:underline">
            &larr; Back to Reservations Desk
        </a>
        <div class="flex items-center gap-2">
            <span class="text-xs text-slate-400">Current Stay Status:</span>
            <span class="px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800">
                Pending Check-in (Arrival Expected Today)
            </span>
        </div>
    </div>

    <!-- Main Desk Operations Card -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <!-- Col 1: Stay & Guest Details (8 cols) -->
        <div class="lg:col-span-8 space-y-6">
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs space-y-6">
                <!-- Guest Header -->
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center pb-4 border-b border-slate-100 gap-2">
                    <div>
                        <span class="text-xs text-slate-400">Guest Information</span>
                        <h2 class="text-xl font-bold text-slate-900">Juan Dela Cruz</h2>
                        <span class="text-xs text-slate-500">Phone: 0917-123-4567 | Email: guest@example.com</span>
                    </div>
                    <div class="text-right">
                        <span class="text-xs text-slate-400 block">Assigned Unit</span>
                        <strong class="text-base text-indigo-700">Room 205 (Double-bed)</strong>
                    </div>
                </div>

                <!-- Stay Details Grid -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-xs">
                    <div>
                        <span class="text-slate-400 block mb-0.5">Check-in Date</span>
                        <strong class="text-slate-900">{{ date('M d, Y') }}</strong>
                    </div>
                    <div>
                        <span class="text-slate-400 block mb-0.5">Check-out Date</span>
                        <strong class="text-slate-900">{{ date('M d, Y', strtotime('+1 day')) }}</strong>
                    </div>
                    <div>
                        <span class="text-slate-400 block mb-0.5">Total Nights</span>
                        <strong class="text-slate-900">1 Night</strong>
                    </div>
                    <div>
                        <span class="text-slate-400 block mb-0.5">Room Rate</span>
                        <strong class="text-slate-900">₱1,999.00</strong>
                    </div>
                </div>

                <!-- Billing & Deposit State -->
                <div class="bg-slate-50 rounded-xl p-4 border border-slate-100 text-xs space-y-2">
                    <div class="flex justify-between">
                        <span class="text-slate-600">Total Booking Cost:</span>
                        <strong class="text-slate-900">₱1,999.00</strong>
                    </div>
                    <div class="flex justify-between text-emerald-700">
                        <span>Deposit Collected (50% OTC):</span>
                        <strong class="font-bold">₱1,000.00 (Verified)</strong>
                    </div>
                    <div class="flex justify-between text-rose-600 font-semibold">
                        <span>Balance Due from Guest at Check-in:</span>
                        <strong>₱999.00</strong>
                    </div>
                </div>

                <!-- Confirmation Remarks / Front Desk Log -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Front Desk Confirmation Remarks</label>
                    <textarea x-model="remarks" rows="2" class="w-full text-xs rounded-xl border-slate-200 focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                </div>
            </div>
        </div>

        <!-- Col 2: Action Control Panel (4 cols) -->
        <div class="lg:col-span-4 space-y-4">
            <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-xs space-y-3">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-500 pb-2 border-b border-slate-100">
                    Front Desk Status Actions
                </h3>

                <!-- 1. Check in button -->
                <button onclick="alert('Guest Juan Dela Cruz marked as CHECKED IN. Room 205 status updated to Booked.')" class="w-full py-2.5 px-4 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-xs flex items-center justify-center gap-2 transition shadow-xs">
                    <i class="ri-login-box-line text-sm"></i> Check In Guest
                </button>

                <!-- 2. Check out button -->
                <button onclick="alert('Guest Juan Dela Cruz marked as CHECKED OUT. Room 205 released for housekeeping/available.')" class="w-full py-2.5 px-4 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-semibold text-xs flex items-center justify-center gap-2 transition">
                    <i class="ri-logout-box-line text-sm"></i> Check Out &amp; Release Room
                </button>

                <!-- 3. Log No-show -->
                <button onclick="alert('Logged as NO-SHOW (Guest didn\'t check in). Room 205 released for new bookings.')" class="w-full py-2.5 px-4 rounded-xl bg-amber-50 hover:bg-amber-100 text-amber-800 font-semibold text-xs border border-amber-200 flex items-center justify-center gap-2 transition">
                    <i class="ri-user-unfollow-line text-sm"></i> Log No-Show (Didn't check in)
                </button>

                <!-- 4. Log Overstay -->
                <button onclick="alert('Logged as OVERSTAY (Guest did not check out on schedule). Extra night charges flagged.')" class="w-full py-2.5 px-4 rounded-xl bg-purple-50 hover:bg-purple-100 text-purple-800 font-semibold text-xs border border-purple-200 flex items-center justify-center gap-2 transition">
                    <i class="ri-time-line text-sm"></i> Log Overstay (Didn't check out)
                </button>

                <hr class="border-slate-100 my-2">

                <!-- Print Invoice -->
                <a href="{{ route('admin.payments.invoice', 1) }}" class="w-full py-2 px-4 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 font-semibold text-xs flex items-center justify-center gap-2 transition">
                    <i class="ri-printer-line"></i> Generate Guest Invoice
                </a>

                <!-- Cancel Booking -->
                <button onclick="if(confirm('Cancel this booking? Room 205 will be released and 80% refund (₱800) logged.')) alert('Reservation cancelled and 80% refund processed.');" class="w-full py-2 px-4 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-700 font-semibold text-xs border border-rose-200 flex items-center justify-center gap-2 transition">
                    <i class="ri-close-circle-line"></i> Cancel Reservation (20% fee)
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
