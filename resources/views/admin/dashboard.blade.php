@extends('layouts.admin')

@section('page-title', 'Backoffice & Front Desk Dashboard')
@section('page-subtitle', 'Real-time room occupancy, today\'s arrivals, and operations overview')

@section('content')
<div class="space-y-6">
    <!-- Top KPI Metric Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- Card 1: Total Rooms -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">Total Inventory</span>
                <span class="text-2xl font-bold text-slate-900 mt-1 block">31 Rooms</span>
                <span class="text-[11px] text-slate-400">Single: 15, Double: 10, Family: 5, Sup: 1</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-2xl shrink-0">
                <i class="ri-hotel-bed-line"></i>
            </div>
        </div>

        <!-- Card 2: Available Rooms -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">Currently Available</span>
                <span class="text-2xl font-bold text-emerald-600 mt-1 block">15 Rooms</span>
                <span class="text-[11px] text-emerald-600 font-medium">Ready for Guest Check-in</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-2xl shrink-0">
                <i class="ri-checkbox-circle-line"></i>
            </div>
        </div>

        <!-- Card 3: Booked / Occupied -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">Booked / Occupied</span>
                <span class="text-2xl font-bold text-blue-600 mt-1 block">10 Rooms</span>
                <span class="text-[11px] text-slate-400">32% Occupancy Rate</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-2xl shrink-0">
                <i class="ri-user-shared-line"></i>
            </div>
        </div>

        <!-- Card 4: Maintenance / Unavailable -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">Unavailable / Hold</span>
                <span class="text-2xl font-bold text-amber-600 mt-1 block">6 Rooms</span>
                <span class="text-[11px] text-amber-600">Hidden from Guest Search</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-2xl shrink-0">
                <i class="ri-tools-line"></i>
            </div>
        </div>
    </div>

    <!-- Quick Front Desk Actions -->
    <div class="bg-indigo-900 rounded-2xl p-6 text-white flex flex-col md:flex-row md:items-center justify-between gap-4 shadow-md">
        <div>
            <h3 class="text-lg font-bold">Front Desk Quick Actions</h3>
            <p class="text-xs text-indigo-200 mt-0.5">Quickly register walk-in guests, verify E-wallet payments, or look up booking codes.</p>
        </div>
        <div class="flex flex-wrap gap-2.5">
            <a href="{{ route('admin.reservations.create') }}" class="px-4 py-2 rounded-xl bg-amber-400 hover:bg-amber-500 text-slate-950 font-bold text-xs shadow-xs transition flex items-center gap-1.5">
                <i class="ri-user-add-line"></i> Walk-in Booking
            </a>
            <a href="{{ route('admin.payments.index') }}" class="px-4 py-2 rounded-xl bg-indigo-800 hover:bg-indigo-700 text-white font-semibold text-xs transition border border-indigo-700 flex items-center gap-1.5">
                <i class="ri-qr-code-line"></i> Verify E-Wallets
            </a>
            <a href="{{ route('admin.rooms.index') }}" class="px-4 py-2 rounded-xl bg-indigo-800 hover:bg-indigo-700 text-white font-semibold text-xs transition border border-indigo-700 flex items-center gap-1.5">
                <i class="ri-hotel-bed-line"></i> Room Status Grid
            </a>
        </div>
    </div>

    <!-- Today's Front Desk Activity Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex justify-between items-center">
            <div>
                <h3 class="font-bold text-slate-900 text-sm">Today's Scheduled Arrivals &amp; Stay Status</h3>
                <p class="text-xs text-slate-500 mt-0.5">Manage Check-in, Check-out, or flag No-Show and Overstay remarks.</p>
            </div>
            <a href="{{ route('admin.reservations.index') }}" class="text-xs font-semibold text-indigo-600 hover:underline">
                View All Reservations &rarr;
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 uppercase tracking-wider font-semibold">
                        <th class="py-3.5 px-5">Code</th>
                        <th class="py-3.5 px-5">Guest Name</th>
                        <th class="py-3.5 px-5">Room Category &amp; No.</th>
                        <th class="py-3.5 px-5">Check-in Date</th>
                        <th class="py-3.5 px-5">Payment / Balance</th>
                        <th class="py-3.5 px-5">Stay Status</th>
                        <th class="py-3.5 px-5 text-right">Desk Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    <!-- Row 1: Expected Arrival -->
                    <tr class="hover:bg-slate-50/80 transition">
                        <td class="py-3.5 px-5 font-mono font-bold text-indigo-600">IH-2026-8492</td>
                        <td class="py-3.5 px-5 font-semibold text-slate-900">Juan Dela Cruz</td>
                        <td class="py-3.5 px-5">Double-bed (Unit 205)</td>
                        <td class="py-3.5 px-5">{{ date('M d, Y') }} (Today)</td>
                        <td class="py-3.5 px-5">
                            <span class="text-emerald-700 font-semibold">50% Paid (₱1,000)</span>
                            <span class="block text-[10px] text-slate-400">Bal: ₱999 due</span>
                        </td>
                        <td class="py-3.5 px-5">
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800">
                                Pending Check-in
                            </span>
                        </td>
                        <td class="py-3.5 px-5 text-right space-x-1.5">
                            <a href="{{ route('admin.reservations.show', 1) }}" class="px-3 py-1 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-semibold text-xs inline-flex items-center gap-1">
                                <i class="ri-login-box-line"></i> Check In
                            </a>
                        </td>
                    </tr>

                    <!-- Row 2: Currently Checked In -->
                    <tr class="hover:bg-slate-50/80 transition">
                        <td class="py-3.5 px-5 font-mono font-bold text-indigo-600">IH-2026-7911</td>
                        <td class="py-3.5 px-5 font-semibold text-slate-900">Maria Santos</td>
                        <td class="py-3.5 px-5">Family Room (Unit 301)</td>
                        <td class="py-3.5 px-5">Nov 21 &rarr; Today</td>
                        <td class="py-3.5 px-5">
                            <span class="text-emerald-700 font-semibold">Fully Settled</span>
                            <span class="block text-[10px] text-slate-400">E-Wallet QR (₱2,999)</span>
                        </td>
                        <td class="py-3.5 px-5">
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                Checked In
                            </span>
                        </td>
                        <td class="py-3.5 px-5 text-right space-x-1.5">
                            <a href="{{ route('admin.reservations.show', 2) }}" class="px-3 py-1 bg-slate-900 hover:bg-slate-800 text-white rounded-lg font-semibold text-xs inline-flex items-center gap-1">
                                <i class="ri-logout-box-line"></i> Check Out
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
