@extends('layouts.admin')

@section('page-subtitle', 'Dashboard')

@section('dashboard')
<div class="space-y-6">
    <!-- Top KPI Metric Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- Card 1: Total Rooms -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs flex items-center justify-between">
            <div>
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">Total Rooms</span>
                <span class="text-2xl font-bold text-slate-900 mt-1 block">31 Rooms</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-gray-400/10 text-black flex items-center justify-center text-2xl shrink-0">
                <i class="ri-hotel-bed-line"></i>
            </div>
        </div>

        <!-- Card 2: Available Rooms -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs flex items-center justify-between">
            <div>
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">Available Rooms</span>
                <span class="text-2xl font-bold text-emerald-600 mt-1 block">15 Rooms</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-2xl shrink-0">
                <i class="ri-checkbox-circle-line"></i>
            </div>
        </div>

        <!-- Card 3: Booked / Occupied -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs flex items-center justify-between">
            <div>
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">Booked Rooms</span>
                <span class="text-2xl font-bold text-blue-600 mt-1 block">10 Rooms</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-blue-600/10 text-blue-600 flex items-center justify-center text-2xl shrink-0">
                <i class="ri-user-shared-line"></i>
            </div>
        </div>

        <!-- Card 4: Maintenance / Unavailable -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs flex items-center justify-between">
            <div>
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">Unavailable Rooms</span>
                <span class="text-2xl font-bold text-red-500 mt-1 block">6 Rooms</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-red-50 text-red-500 flex items-center justify-center text-2xl shrink-0">
                <i class="ri-tools-line"></i>
            </div>
        </div>
    </div>

    <!-- Today's Front Desk Activity Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-2xs overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex justify-between items-center">
            <div>
                <h3 class="font-bold text-slate-900 text-sm">Scheduled Arrivals &amp; Stay Status</h3>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 uppercase tracking-wider font-semibold">
                        <th class="py-3.5 px-5">Code</th>
                        <th class="py-3.5 px-5">Guest Name</th>
                        <th class="py-3.5 px-5">Room Category &amp; No.</th>
                        <th class="py-3.5 px-5">Check-in Date</th>
                        <th class="py-3.5 px-5">Check-out Date</th>
                        <th class="py-3.5 px-5">Payment / Balance</th>
                        <th class="py-3.5 px-5">Stay Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    <!-- Row 1: Expected Arrival -->
                    <tr class="hover:bg-slate-50/80 transition">
                        <td class="py-3.5 px-5 font-mono font-bold text-[#06923E]">IH-2026-8492</td>
                        <td class="py-3.5 px-5 font-semibold text-slate-900">Juan Dela Cruz</td>
                        <td class="py-3.5 px-5">Double-bed (Unit 205)</td>
                        <td class="py-3.5 px-5">{{ date('M d, Y') }} (Today)</td>
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
                    </tr>

                    <!-- Row 2: Currently Checked In -->
                    <tr class="hover:bg-slate-50/80 transition">
                        <td class="py-3.5 px-5 font-mono font-bold text-[#06923E]">IH-2026-7911</td>
                        <td class="py-3.5 px-5 font-semibold text-slate-900">Maria Santos</td>
                        <td class="py-3.5 px-5">Family Room (Unit 301)</td>
                        <td class="py-3.5 px-5">Nov 21 &rarr; Today</td>
                        <td class="py-3.5 px-5">{{ date('M d, Y') }} (Today)</td>
                        <td class="py-3.5 px-5">
                            <span class="text-emerald-700 font-semibold">Fully Settled</span>
                            <span class="block text-[10px] text-slate-400">E-Wallet QR (₱2,999)</span>
                        </td>
                        <td class="py-3.5 px-5">
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                Checked In
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
