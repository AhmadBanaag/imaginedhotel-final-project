@extends('layouts.admin')

@section('page-title', 'Walk-in Guest Reservation')
@section('page-subtitle', 'Front desk registration for direct walk-in guests at reception')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-4">
        <a href="{{ route('admin.reservations.index') }}" class="text-xs font-semibold text-indigo-600 hover:underline">
            &larr; Back to Master Reservations Desk
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-2xs p-6 sm:p-8 space-y-6">
        <h2 class="text-lg font-bold text-slate-900 pb-3 border-b border-slate-100">Walk-in Guest Registration Form</h2>

        <form action="{{ route('admin.reservations.index') }}" method="GET" class="space-y-4">
            <!-- Guest Contact -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">First Name</label>
                    <input type="text" name="first_name" required placeholder="Guest First Name" class="w-full text-sm rounded-xl border-slate-200 focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Last Name</label>
                    <input type="text" name="last_name" required placeholder="Guest Last Name" class="w-full text-sm rounded-xl border-slate-200 focus:ring-indigo-500 focus:border-indigo-500">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Phone Number</label>
                    <input type="tel" name="phone_number" required placeholder="e.g. 0917-000-0000" class="w-full text-sm rounded-xl border-slate-200 focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Email (Optional)</label>
                    <input type="email" name="email" placeholder="e.g. guest@example.com" class="w-full text-sm rounded-xl border-slate-200 focus:ring-indigo-500 focus:border-indigo-500">
                </div>
            </div>

            <!-- Room & Dates -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Room Selection</label>
                    <select name="room_id" class="w-full text-sm rounded-xl border-slate-200 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="101">Room 101 (Single - ₱999)</option>
                        <option value="103">Room 103 (Single - ₱999)</option>
                        <option value="202">Room 202 (Double - ₱1,999)</option>
                        <option value="203">Room 203 (Double - ₱1,999)</option>
                        <option value="302">Room 302 (Family - ₱2,999)</option>
                        <option value="401">Room 401 (Superior VIP - ₱4,999)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Check-in Date</label>
                    <input type="date" name="check_in" value="{{ date('Y-m-d') }}" class="w-full text-sm rounded-xl border-slate-200 focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Check-out Date</label>
                    <input type="date" name="check_out" value="{{ date('Y-m-d', strtotime('+1 day')) }}" class="w-full text-sm rounded-xl border-slate-200 focus:ring-indigo-500 focus:border-indigo-500">
                </div>
            </div>

            <!-- Payment Type -->
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Payment Received</label>
                <div class="grid grid-cols-2 gap-4">
                    <label class="p-3 border rounded-xl flex items-center gap-2 cursor-pointer bg-slate-50">
                        <input type="radio" name="payment_type" value="otc_50" checked class="text-indigo-600 focus:ring-indigo-500">
                        <span class="text-xs font-medium text-slate-800">50% Cash Downpayment Received</span>
                    </label>
                    <label class="p-3 border rounded-xl flex items-center gap-2 cursor-pointer bg-slate-50">
                        <input type="radio" name="payment_type" value="full_paid" class="text-indigo-600 focus:ring-indigo-500">
                        <span class="text-xs font-medium text-slate-800">100% Full Payment Settled</span>
                    </label>
                </div>
            </div>

            <!-- Confirmation Remarks -->
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Front Desk Confirmation Remarks</label>
                <textarea name="remarks" rows="2" placeholder="e.g. Verified walk-in guest ID, issued room key card." class="w-full text-sm rounded-xl border-slate-200 focus:ring-indigo-500 focus:border-indigo-500"></textarea>
            </div>

            <div class="pt-4 border-t border-slate-100 flex gap-3">
                <button type="submit" class="flex-1 py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs transition">
                    Register Walk-in Guest &amp; Issue Room Key
                </button>
                <a href="{{ route('admin.reservations.index') }}" class="py-3 px-5 rounded-xl border border-slate-200 text-slate-700 text-xs font-semibold hover:bg-slate-50 transition">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
