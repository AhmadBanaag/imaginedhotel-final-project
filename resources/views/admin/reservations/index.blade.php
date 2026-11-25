@extends('layouts.admin')

@section('page-subtitle', 'Reservations Desk')

@section('content')
<div class="space-y-6" x-data="{
    activeTab: 'all',
    searchQuery: '',
    tabs: [
        { key: 'all', label: 'All Bookings' },
        { key: 'pending', label: 'Pending Verification' },
        { key: 'confirmed', label: 'Confirmed' },
        { key: 'checked_in', label: 'Checked In' },
        { key: 'checked_out', label: 'Checked Out' },
        { key: 'cancelled', label: 'Cancelled (80% Refund)' },
        { key: 'no_show', label: 'No-Show / Overstay' }
    ],
    bookings: [
        {
            id: 1,
            code: 'IH-2026-8492',
            guest: 'Juan Dela Cruz',
            phone: '0917-123-4567',
            category: 'Double-bed Room',
            unit: 'Unit 205 (Floor 2)',
            dates: '{{ date('M d') }} → {{ date('M d', strtotime('+1 day')) }}',
            nights: '1 Night',
            method: 'OTC (50% Deposit)',
            methodClass: 'bg-amber-50 text-amber-800',
            total: '₱1,999',
            balanceText: '₱999 bal at check-in',
            balanceClass: 'text-rose-600',
            status: 'pending',
            statusLabel: 'Pending Verification',
            statusClass: 'bg-amber-100 text-amber-800'
        },
        {
            id: 2,
            code: 'IH-2026-7911',
            guest: 'Maria Santos',
            phone: '0918-987-6543',
            category: 'Family Room',
            unit: 'Unit 301 (Floor 3)',
            dates: 'Nov 24 → {{ date('M d') }}',
            nights: '2 Nights',
            method: 'E-Wallet QR',
            methodClass: 'bg-emerald-50 text-emerald-700',
            total: '₱5,998',
            balanceText: 'Fully Settled',
            balanceClass: 'text-emerald-600',
            status: 'checked_in',
            statusLabel: 'Checked In',
            statusClass: 'bg-emerald-100 text-emerald-800'
        },
        {
            id: 3,
            code: 'IH-2026-8504',
            guest: 'Mark Villanueva',
            phone: '0919-442-8810',
            category: 'Single-bed Room',
            unit: 'Unit 104 (Floor 1)',
            dates: '{{ date('M d', strtotime('+1 day')) }} → {{ date('M d', strtotime('+3 days')) }}',
            nights: '2 Nights',
            method: 'E-Wallet QR',
            methodClass: 'bg-emerald-50 text-emerald-700',
            total: '₱1,998',
            balanceText: 'Fully Settled',
            balanceClass: 'text-emerald-600',
            status: 'confirmed',
            statusLabel: 'Confirmed',
            statusClass: 'bg-blue-100 text-blue-800'
        },
        {
            id: 4,
            code: 'IH-2026-8450',
            guest: 'Elena Mendoza',
            phone: '0917-650-3321',
            category: 'Superior Room (VIP)',
            unit: 'Unit 401 (Floor 4)',
            dates: 'Nov 20 → Nov 22',
            nights: '2 Nights',
            method: 'E-Wallet QR',
            methodClass: 'bg-emerald-50 text-emerald-700',
            total: '₱9,998',
            balanceText: 'Settled at Checkout',
            balanceClass: 'text-slate-500',
            status: 'checked_out',
            statusLabel: 'Checked Out',
            statusClass: 'bg-slate-100 text-slate-700'
        },
        {
            id: 5,
            code: 'IH-2026-8398',
            guest: 'Paolo Reyes',
            phone: '0920-771-1904',
            category: 'Double-bed Room',
            unit: 'Unit 208 (Floor 2)',
            dates: 'Nov 23 → Nov 24',
            nights: '1 Night',
            method: 'OTC (50% Deposit)',
            methodClass: 'bg-amber-50 text-amber-800',
            total: '₱1,999',
            balanceText: '₱800 Refunded (20% fee)',
            balanceClass: 'text-rose-600',
            status: 'cancelled',
            statusLabel: 'Cancelled',
            statusClass: 'bg-rose-100 text-rose-800'
        },
        {
            id: 6,
            code: 'IH-2026-8371',
            guest: 'Ramon Bautista',
            phone: '0916-308-7745',
            category: 'Single-bed Room',
            unit: 'Unit 109 (Floor 1)',
            dates: 'Nov 22 → Nov 23',
            nights: '1 Night',
            method: 'OTC (50% Deposit)',
            methodClass: 'bg-amber-50 text-amber-800',
            total: '₱999',
            balanceText: 'No-Show Logged (Room Released)',
            balanceClass: 'text-purple-700',
            status: 'no_show',
            statusLabel: 'No-Show',
            statusClass: 'bg-purple-100 text-purple-800'
        }
    ],
    countFor(key) {
        if (key === 'all') return this.bookings.length;
        return this.bookings.filter(b => b.status === key).length;
    },
    get filteredBookings() {
        const q = this.searchQuery.trim().toLowerCase();
        return this.bookings.filter(b => {
            const matchesTab = this.activeTab === 'all' || b.status === this.activeTab;
            const matchesSearch = !q || b.code.toLowerCase().includes(q) || b.guest.toLowerCase().includes(q) || b.unit.toLowerCase().includes(q) || b.category.toLowerCase().includes(q);
            return matchesTab && matchesSearch;
        });
    }
}">
    <!-- Top Summary Strip -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-2xs flex items-center justify-between">
            <div>
                <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider block">Total Active Ledger</span>
                <span class="text-xl font-bold text-slate-900 mt-0.5 block" x-text="bookings.length + ' Bookings'"></span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-[#EDC92C]/20 text-[#EDC92C] flex items-center justify-center text-xl">
                <i class="ri-calendar-event-line"></i>
            </div>
        </div>
        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-2xs flex items-center justify-between">
            <div>
                <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider block">Pending Verification</span>
                <span class="text-xl font-bold text-amber-600 mt-0.5 block" x-text="countFor('pending') + ' Arrival'"></span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl">
                <i class="ri-time-line"></i>
            </div>
        </div>
        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-2xs flex items-center justify-between">
            <div>
                <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider block">Currently Checked In</span>
                <span class="text-xl font-bold text-[#06923E] mt-0.5 block" x-text="countFor('checked_in') + ' In-House'"></span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-[#06923E] flex items-center justify-center text-xl">
                <i class="ri-hotel-bed-line"></i>
            </div>
        </div>
        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-2xs flex items-center justify-between">
            <div>
                <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider block">Cancelled / No-Show</span>
                <span class="text-xl font-bold text-rose-600 mt-0.5 block" x-text="(countFor('cancelled') + countFor('no_show')) + ' Flagged'"></span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center text-xl">
                <i class="ri-error-warning-line"></i>
            </div>
        </div>
    </div>

    <!-- Action Bar, Search & Filter Tabs -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs space-y-4">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="relative w-full md:max-w-sm">
                <i class="ri-search-line absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input type="text" x-model="searchQuery" placeholder="Search booking code, guest, or room unit..." class="w-full pl-10 pr-4 py-2 text-xs rounded-xl border-slate-200 focus:ring-[#EDC92C] focus:border-[#EDC92C]">
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.reservations.create') }}" class="px-4 py-2 bg-[#06923E] hover:bg-[#057a34] text-white font-semibold text-xs rounded-xl shadow-2xs transition inline-flex items-center gap-1.5">
                    <i class="ri-user-add-line"></i> Walk-in Booking
                </a>
            </div>
        </div>

        <!-- Filter Tabs -->
        <div class="flex flex-wrap gap-1.5 text-xs pt-2 border-t border-slate-100">
            <template x-for="tab in tabs" :key="tab.key">
                <button @click="activeTab = tab.key"
                    :class="activeTab === tab.key ? 'bg-slate-900 text-white font-bold' : 'bg-slate-100 text-slate-700 hover:bg-slate-200'"
                    class="px-3 py-1.5 rounded-lg transition inline-flex items-center gap-1.5">
                    <span x-text="tab.label"></span>
                    <span :class="activeTab === tab.key ? 'bg-[#EDC92C] text-slate-950' : 'bg-white text-slate-600'"
                        class="px-1.5 py-0.2 rounded-full text-[10px] font-bold"
                        x-text="countFor(tab.key)"></span>
                </button>
            </template>
        </div>
    </div>

    <!-- Reservations Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-2xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 uppercase tracking-wider font-semibold">
                        <th class="py-3.5 px-5">Code</th>
                        <th class="py-3.5 px-5">Guest Info</th>
                        <th class="py-3.5 px-5">Room Assignment</th>
                        <th class="py-3.5 px-5">Stay Dates</th>
                        <th class="py-3.5 px-5">Payment Method</th>
                        <th class="py-3.5 px-5">Total / Balance</th>
                        <th class="py-3.5 px-5">Status</th>
                        <th class="py-3.5 px-5 text-right">Desk Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    <template x-for="booking in filteredBookings" :key="booking.id">
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="py-3.5 px-5 font-mono font-bold text-slate-900" x-text="booking.code"></td>
                            <td class="py-3.5 px-5">
                                <span class="font-bold text-slate-900 block" x-text="booking.guest"></span>
                                <span class="text-[11px] text-slate-400" x-text="booking.phone"></span>
                            </td>
                            <td class="py-3.5 px-5">
                                <span class="font-medium text-slate-800" x-text="booking.category"></span>
                                <span class="block text-[10px] text-slate-400" x-text="booking.unit"></span>
                            </td>
                            <td class="py-3.5 px-5">
                                <span x-text="booking.dates"></span>
                                <span class="block text-[10px] text-slate-400" x-text="booking.nights"></span>
                            </td>
                            <td class="py-3.5 px-5">
                                <span :class="booking.methodClass" class="px-2 py-0.5 rounded-sm font-medium" x-text="booking.method"></span>
                            </td>
                            <td class="py-3.5 px-5">
                                <span class="font-bold text-slate-900" x-text="booking.total"></span>
                                <span :class="booking.balanceClass" class="block text-[10px]" x-text="booking.balanceText"></span>
                            </td>
                            <td class="py-3.5 px-5">
                                <span :class="booking.statusClass" class="px-2.5 py-0.5 rounded-full text-[10px] font-bold" x-text="booking.statusLabel"></span>
                            </td>
                            <td class="py-3.5 px-5 text-right">
                                <a :href="'{{ url('/admin/reservations') }}/' + booking.id" class="px-3 py-1.5 rounded-lg bg-[#EDC92C] hover:bg-[#06923E] text-slate-950 hover:text-white font-semibold text-xs transition inline-flex items-center gap-1">
                                    Manage &rarr;
                                </a>
                            </td>
                        </tr>
                    </template>
                    <tr x-show="filteredBookings.length === 0">
                        <td colspan="8" class="py-10 text-center text-slate-400">
                            <i class="ri-inbox-line text-3xl block mb-2"></i>
                            No reservations match the selected filter or search query.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
