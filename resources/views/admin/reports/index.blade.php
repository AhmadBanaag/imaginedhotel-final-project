@extends('layouts.admin')

@section('page-title', 'Monthly Reservation & Revenue Reports')
@section('page-subtitle', 'Monthly booking performance, occupancy rates, and OTC vs. E-Wallet revenue analytics')

@section('content')
<div class="space-y-6">
    <!-- Month Filter & Print Bar -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <label class="text-xs font-semibold text-slate-700">Select Report Month:</label>
            <select class="text-xs rounded-xl border-slate-200 focus:ring-indigo-500 focus:border-indigo-500 py-1.5 px-3">
                <option selected>November 2026 (Current Period)</option>
                <option>October 2026</option>
                <option>September 2026</option>
            </select>
        </div>
        <button onclick="window.print()" class="px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white font-semibold text-xs rounded-xl transition flex items-center gap-1.5">
            <i class="ri-printer-line"></i> Print Monthly Summary
        </button>
    </div>

    <!-- Monthly KPI Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs">
            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">Total Bookings (Nov)</span>
            <div class="text-2xl font-bold text-slate-900 mt-1">48 Stays</div>
            <span class="text-[11px] text-emerald-600 font-medium">+14% vs previous month</span>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs">
            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">Gross Revenue</span>
            <div class="text-2xl font-bold text-indigo-700 mt-1">₱94,500.00</div>
            <span class="text-[11px] text-slate-400">Total room sales</span>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs">
            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">Average Occupancy</span>
            <div class="text-2xl font-bold text-emerald-600 mt-1">68.4%</div>
            <span class="text-[11px] text-slate-400">Across 31 available units</span>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs">
            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">Cancellations &amp; Fees</span>
            <div class="text-2xl font-bold text-amber-600 mt-1">3 Bookings</div>
            <span class="text-[11px] text-slate-400">₱1,200 (20% fee retained)</span>
        </div>
    </div>

    <!-- Breakdown by Room Category -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-2xs overflow-hidden">
        <div class="p-5 border-b border-slate-100">
            <h3 class="font-bold text-slate-900 text-sm">Monthly Performance by Room Category</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 uppercase font-semibold">
                        <th class="py-3 px-5">Category</th>
                        <th class="py-3 px-5">Inventory</th>
                        <th class="py-3 px-5">Rate / Night</th>
                        <th class="py-3 px-5">Monthly Bookings</th>
                        <th class="py-3 px-5">Revenue Generated</th>
                        <th class="py-3 px-5 text-right">Occupancy Contribution</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    <tr>
                        <td class="py-3.5 px-5 font-semibold text-slate-900">Single-bed room</td>
                        <td class="py-3.5 px-5">15 Units</td>
                        <td class="py-3.5 px-5 font-semibold">₱999.00</td>
                        <td class="py-3.5 px-5">24 stays</td>
                        <td class="py-3.5 px-5 font-bold text-indigo-700">₱23,976.00</td>
                        <td class="py-3.5 px-5 text-right font-medium text-emerald-600">50.0%</td>
                    </tr>
                    <tr>
                        <td class="py-3.5 px-5 font-semibold text-slate-900">Double-bed room</td>
                        <td class="py-3.5 px-5">10 Units</td>
                        <td class="py-3.5 px-5 font-semibold">₱1,999.00</td>
                        <td class="py-3.5 px-5">14 stays</td>
                        <td class="py-3.5 px-5 font-bold text-indigo-700">₱27,986.00</td>
                        <td class="py-3.5 px-5 text-right font-medium text-emerald-600">29.1%</td>
                    </tr>
                    <tr>
                        <td class="py-3.5 px-5 font-semibold text-slate-900">Family Room</td>
                        <td class="py-3.5 px-5">5 Units</td>
                        <td class="py-3.5 px-5 font-semibold">₱2,999.00</td>
                        <td class="py-3.5 px-5">8 stays</td>
                        <td class="py-3.5 px-5 font-bold text-indigo-700">₱23,992.00</td>
                        <td class="py-3.5 px-5 text-right font-medium text-emerald-600">16.6%</td>
                    </tr>
                    <tr class="bg-amber-50/20">
                        <td class="py-3.5 px-5 font-bold text-slate-900">Superior Room (VIP)</td>
                        <td class="py-3.5 px-5">1 Unit</td>
                        <td class="py-3.5 px-5 font-bold text-amber-600">₱4,999.00</td>
                        <td class="py-3.5 px-5">3 stays</td>
                        <td class="py-3.5 px-5 font-bold text-indigo-700">₱14,997.00</td>
                        <td class="py-3.5 px-5 text-right font-medium text-amber-700">6.2%</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
