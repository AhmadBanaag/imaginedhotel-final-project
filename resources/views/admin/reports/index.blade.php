@extends('layouts.admin')

@section('page-subtitle', 'Monthly Reports')

@section('content')
<div class="space-y-6">
    <!-- Month Filter -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <form action="{{ route('admin.reports.index') }}" method="GET" class="flex items-center gap-3">
            <label for="report-month" class="text-xs font-semibold text-slate-700">Select Report Period:</label>
            <select id="report-month" name="month" onchange="this.form.submit()"
                class="text-xs rounded-xl border-slate-200 focus:ring-[#EDC92C] focus:border-[#EDC92C] py-1.5 pl-2 pr-7">
                @foreach ($availableMonths as $value => $label)
                    <option value="{{ $value }}" @selected($selectedMonth === $value)>
                        {{ $label }}@if ($value === now()->format('Y-m')) (Current Period)@endif
                    </option>
                @endforeach
            </select>
        </form>
    </div>

    <!-- Monthly KPI Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs">
            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">
                Total Bookings ({{ $report['label'] }})
            </span>
            <div class="text-2xl font-bold text-slate-900 mt-1">{{ $report['total_stays'] }} Stays</div>
            <span class="text-[11px] text-[#06923E] font-medium">{{ $report['trend'] }}</span>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs">
            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">Gross Room Revenue</span>
            <div class="text-2xl font-bold text-[#06923E] mt-1">₱{{ number_format($report['gross_revenue'], 2) }}</div>
            <span class="text-[11px] text-slate-400">Reconciled across {{ $report['categories']->count() }} categories</span>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs">
            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">Average Occupancy</span>
            <div class="text-2xl font-bold text-blue-600 mt-1">{{ number_format($report['occupancy_pct'], 1) }}%</div>
            <span class="text-[11px] text-slate-400">Across {{ $report['total_units'] }} total units</span>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs">
            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">Cancellations &amp; Fees</span>
            <div class="text-2xl font-bold text-amber-600 mt-1">{{ $report['cancellations'] }} Bookings</div>
            <span class="text-[11px] text-slate-400">₱{{ number_format($report['retained_fees'], 2) }} retained</span>
        </div>
    </div>

    <!-- Payment Channel Split -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs space-y-3">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
            <h3 class="font-bold text-slate-900 text-sm">Revenue: Over-the-Counter vs. E-Wallet</h3>
            <div class="flex items-center gap-4 text-xs">
                <span class="inline-flex items-center gap-1.5 font-semibold text-slate-700">
                    <span class="w-2.5 h-2.5 rounded-full bg-[#EDC92C]"></span>
                    OTC ({{ $report['otc_pct'] }}%) — ₱{{ number_format($report['otc_revenue'], 2) }}
                </span>
                <span class="inline-flex items-center gap-1.5 font-semibold text-slate-700">
                    <span class="w-2.5 h-2.5 rounded-full bg-[#06923E]"></span>
                    E-Wallet ({{ $report['ewallet_pct'] }}%) — ₱{{ number_format($report['ewallet_revenue'], 2) }}
                </span>
            </div>
        </div>
        <div class="w-full h-3 rounded-full bg-slate-100 overflow-hidden flex">
            <div class="bg-[#EDC92C] h-full transition-all duration-300" style="width: {{ $report['otc_pct'] }}%"></div>
            <div class="bg-[#06923E] h-full transition-all duration-300" style="width: {{ $report['ewallet_pct'] }}%"></div>
        </div>
    </div>

    <!-- Breakdown by Room Category -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-2xs overflow-hidden">
        <div class="p-5 border-b border-slate-100">
            <h3 class="font-bold text-slate-900 text-sm">
                Monthly Performance by Room Category ({{ $report['label'] }})
            </h3>
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
                        <th class="py-3 px-5 text-right">Booking Share</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse ($report['categories'] as $cat)
                        <tr class="{{ $cat['is_vip'] ? 'bg-amber-50/30' : '' }}">
                            <td class="py-3.5 px-5 font-semibold text-slate-900">{{ $cat['name'] }}</td>
                            <td class="py-3.5 px-5">{{ $cat['units'] }} {{ Str::plural('Unit', $cat['units']) }}</td>
                            <td class="py-3.5 px-5 font-semibold {{ $cat['is_vip'] ? 'text-amber-600' : '' }}">
                                ₱{{ number_format($cat['rate'], 2) }}
                            </td>
                            <td class="py-3.5 px-5">{{ $cat['stays'] }} {{ Str::plural('stay', $cat['stays']) }}</td>
                            <td class="py-3.5 px-5 font-bold text-[#06923E]">₱{{ number_format($cat['revenue'], 2) }}</td>
                            <td class="py-3.5 px-5 text-right font-semibold text-slate-800">
                                {{ number_format($cat['share_pct'], 1) }}%
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-10 text-center text-slate-400">
                                No room categories found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr class="bg-slate-50 border-t border-slate-200 font-bold text-slate-900">
                        <td class="py-3.5 px-5">Total</td>
                        <td class="py-3.5 px-5">{{ $report['total_units'] }} Units</td>
                        <td class="py-3.5 px-5">—</td>
                        <td class="py-3.5 px-5">{{ $report['total_stays'] }} stays</td>
                        <td class="py-3.5 px-5 text-[#06923E]">₱{{ number_format($report['gross_revenue'], 2) }}</td>
                        <td class="py-3.5 px-5 text-right">{{ $report['total_stays'] > 0 ? '100.0%' : '0.0%' }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection