@extends('layouts.admin')

@section('page-subtitle', 'Monthly Reports')

@section('content')
<div class="space-y-6" x-data="{
    selectedMonth: '2026-11',
    reports: {
        '2026-11': {
            label: 'November 2026',
            trend: '+14.0% vs previous month',
            occupancy: '68.4%',
            cancellations: 3,
            retainedFees: 1200,
            otcRevenue: 41951,
            ewalletRevenue: 49000,
            categories: [
                { name: 'Single-bed Room', inventory: '15 Units', rate: 999, stays: 24, isVip: false },
                { name: 'Double-bed Room', inventory: '10 Units', rate: 1999, stays: 14, isVip: false },
                { name: 'Family Room', inventory: '5 Units', rate: 2999, stays: 8, isVip: false },
                { name: 'Superior Room (VIP)', inventory: '1 Unit', rate: 4999, stays: 3, isVip: true }
            ]
        },
        '2026-10': {
            label: 'October 2026',
            trend: '+8.2% vs previous month',
            occupancy: '61.2%',
            cancellations: 2,
            retainedFees: 800,
            otcRevenue: 38978,
            ewalletRevenue: 39979,
            categories: [
                { name: 'Single-bed Room', inventory: '15 Units', rate: 999, stays: 21, isVip: false },
                { name: 'Double-bed Room', inventory: '10 Units', rate: 1999, stays: 13, isVip: false },
                { name: 'Family Room', inventory: '5 Units', rate: 2999, stays: 7, isVip: false },
                { name: 'Superior Room (VIP)', inventory: '1 Unit', rate: 4999, stays: 2, isVip: true }
            ]
        },
        '2026-09': {
            label: 'September 2026',
            trend: 'Baseline Period',
            occupancy: '55.8%',
            cancellations: 4,
            retainedFees: 1400,
            otcRevenue: 35982,
            ewalletRevenue: 36980,
            categories: [
                { name: 'Single-bed Room', inventory: '15 Units', rate: 999, stays: 20, isVip: false },
                { name: 'Double-bed Room', inventory: '10 Units', rate: 1999, stays: 12, isVip: false },
                { name: 'Family Room', inventory: '5 Units', rate: 2999, stays: 6, isVip: false },
                { name: 'Superior Room (VIP)', inventory: '1 Unit', rate: 4999, stays: 2, isVip: true }
            ]
        }
    },
    get current() {
        return this.reports[this.selectedMonth];
    },
    get totalStays() {
        return this.current.categories.reduce((sum, c) => sum + c.stays, 0);
    },
    get grossRevenue() {
        return this.current.categories.reduce((sum, c) => sum + (c.stays * c.rate), 0);
    },
    sharePct(stays) {
        if (!this.totalStays) return '0.0%';
        return ((stays / this.totalStays) * 100).toFixed(1) + '%';
    },
    get otcPct() {
        return Math.round((this.current.otcRevenue / this.grossRevenue) * 100);
    },
    get ewalletPct() {
        return 100 - this.otcPct;
    },
    peso(val) {
        return '₱' + Number(val).toLocaleString('en-PH', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }
}">
    <!-- Month Filter & Print Bar -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs flex flex-col sm:flex-row sm:items-center justify-between gap-4 print:hidden">
        <div class="flex items-center gap-3">
            <label class="text-xs font-semibold text-slate-700">Select Report Period:</label>
            <select x-model="selectedMonth" class="text-xs rounded-xl border-slate-200 focus:ring-[#EDC92C] focus:border-[#EDC92C] py-1.5 px-3">
                <option value="2026-11">November 2026 (Current Period)</option>
                <option value="2026-10">October 2026</option>
                <option value="2026-09">September 2026</option>
            </select>
        </div>
        <button type="button" onclick="window.print()" class="px-4 py-2 bg-slate-900 hover:bg-[#06923E] text-white font-semibold text-xs rounded-xl transition flex items-center gap-1.5">
            <i class="ri-printer-line"></i> Print Monthly Summary
        </button>
    </div>

    <!-- Monthly KPI Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs">
            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">Total Bookings (<span x-text="current.label"></span>)</span>
            <div class="text-2xl font-bold text-slate-900 mt-1" x-text="totalStays + ' Stays'"></div>
            <span class="text-[11px] text-[#06923E] font-medium" x-text="current.trend"></span>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs">
            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">Gross Room Revenue</span>
            <div class="text-2xl font-bold text-[#06923E] mt-1" x-text="peso(grossRevenue)"></div>
            <span class="text-[11px] text-slate-400">Reconciled across 4 categories</span>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs">
            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">Average Occupancy</span>
            <div class="text-2xl font-bold text-blue-600 mt-1" x-text="current.occupancy"></div>
            <span class="text-[11px] text-slate-400">Across 31 total units</span>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs">
            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">Cancellations &amp; Fees</span>
            <div class="text-2xl font-bold text-amber-600 mt-1" x-text="current.cancellations + ' Bookings'"></div>
            <span class="text-[11px] text-slate-400"><span x-text="peso(current.retainedFees)"></span> retained (20% fee)</span>
        </div>
    </div>

    <!-- Payment Channel Split -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs space-y-3">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
            <h3 class="font-bold text-slate-900 text-sm">Revenue Mix: Over-the-Counter vs. E-Wallet QR</h3>
            <div class="flex items-center gap-4 text-xs">
                <span class="inline-flex items-center gap-1.5 font-semibold text-slate-700">
                    <span class="w-2.5 h-2.5 rounded-full bg-[#EDC92C]"></span> OTC (<span x-text="otcPct + '%'"></span>) — <span x-text="peso(current.otcRevenue)"></span>
                </span>
                <span class="inline-flex items-center gap-1.5 font-semibold text-slate-700">
                    <span class="w-2.5 h-2.5 rounded-full bg-[#06923E]"></span> E-Wallet QR (<span x-text="ewalletPct + '%'"></span>) — <span x-text="peso(current.ewalletRevenue)"></span>
                </span>
            </div>
        </div>
        <div class="w-full h-3 rounded-full bg-slate-100 overflow-hidden flex">
            <div class="bg-[#EDC92C] h-full transition-all duration-300" :style="'width: ' + otcPct + '%'"></div>
            <div class="bg-[#06923E] h-full transition-all duration-300" :style="'width: ' + ewalletPct + '%'"></div>
        </div>
    </div>

    <!-- Breakdown by Room Category -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-2xs overflow-hidden">
        <div class="p-5 border-b border-slate-100">
            <h3 class="font-bold text-slate-900 text-sm">Monthly Performance by Room Category (<span x-text="current.label"></span>)</h3>
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
                    <template x-for="cat in current.categories" :key="cat.name">
                        <tr :class="cat.isVip ? 'bg-amber-50/30' : ''">
                            <td class="py-3.5 px-5 font-semibold text-slate-900" x-text="cat.name"></td>
                            <td class="py-3.5 px-5" x-text="cat.inventory"></td>
                            <td class="py-3.5 px-5 font-semibold" :class="cat.isVip ? 'text-amber-600' : ''" x-text="peso(cat.rate)"></td>
                            <td class="py-3.5 px-5" x-text="cat.stays + ' stays'"></td>
                            <td class="py-3.5 px-5 font-bold text-[#06923E]" x-text="peso(cat.stays * cat.rate)"></td>
                            <td class="py-3.5 px-5 text-right font-semibold text-slate-800" x-text="sharePct(cat.stays)"></td>
                        </tr>
                    </template>
                </tbody>
                <tfoot>
                    <tr class="bg-slate-50 border-t border-slate-200 font-bold text-slate-900">
                        <td class="py-3.5 px-5">Total</td>
                        <td class="py-3.5 px-5">31 Units</td>
                        <td class="py-3.5 px-5">—</td>
                        <td class="py-3.5 px-5" x-text="totalStays + ' stays'"></td>
                        <td class="py-3.5 px-5 text-[#06923E]" x-text="peso(grossRevenue)"></td>
                        <td class="py-3.5 px-5 text-right">100.0%</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection
