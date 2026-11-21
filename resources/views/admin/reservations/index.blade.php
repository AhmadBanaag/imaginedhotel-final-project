@extends('layouts.admin')

@section('page-title', 'Front Desk Reservations')
@section('page-subtitle', 'Manage all hotel bookings, verify arrivals, check guests in/out, and handle cancellations')

@section('content')
<div class="space-y-6" x-data="{ activeTab: 'all' }">
    <!-- Action Bar & Tabs -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-4">
        <!-- Filter Tabs -->
        <div class="flex flex-wrap gap-1.5 text-xs">
            <button @click="activeTab = 'all'" :class="activeTab === 'all' ? 'bg-indigo-600 text-white font-bold' : 'bg-slate-100 text-slate-700'" class="px-3 py-1.5 rounded-lg transition">
                All Bookings
            </button>
            <button @click="activeTab = 'pending'" :class="activeTab === 'pending' ? 'bg-indigo-600 text-white font-bold' : 'bg-slate-100 text-slate-700'" class="px-3 py-1.5 rounded-lg transition">
                Pending Verification
            </button>
            <button @click="activeTab = 'confirmed'" :class="activeTab === 'confirmed' ? 'bg-indigo-600 text-white font-bold' : 'bg-slate-100 text-slate-700'" class="px-3 py-1.5 rounded-lg transition">
                Confirmed
            </button>
            <button @click="activeTab = 'checked_in'" :class="activeTab === 'checked_in' ? 'bg-indigo-600 text-white font-bold' : 'bg-slate-100 text-slate-700'" class="px-3 py-1.5 rounded-lg transition">
                Checked In
            </button>
            <button @click="activeTab = 'checked_out'" :class="activeTab === 'checked_out' ? 'bg-indigo-600 text-white font-bold' : 'bg-slate-100 text-slate-700'" class="px-3 py-1.5 rounded-lg transition">
                Checked Out
            </button>
            <button @click="activeTab = 'cancelled'" :class="activeTab === 'cancelled' ? 'bg-indigo-600 text-white font-bold' : 'bg-slate-100 text-slate-700'" class="px-3 py-1.5 rounded-lg transition">
                Cancelled (80% Refund)
            </button>
            <button @click="activeTab = 'no_show'" :class="activeTab === 'no_show' ? 'bg-indigo-600 text-white font-bold' : 'bg-slate-100 text-slate-700'" class="px-3 py-1.5 rounded-lg transition">
                No-Show / Overstay
            </button>
        </div>

        <div>
            <a href="{{ route('admin.reservations.create') }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-xs rounded-xl shadow-xs transition inline-flex items-center gap-1.5">
                <i class="ri-user-add-line"></i> Walk-in Booking
            </a>
        </div>
    </div>

    <!-- Reservations Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
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
                    <!-- Row 1 -->
                    <tr class="hover:bg-slate-50/80 transition">
                        <td class="py-3.5 px-5 font-mono font-bold text-indigo-600">IH-2026-8492</td>
                        <td class="py-3.5 px-5">
                            <span class="font-bold text-slate-900 block">Juan Dela Cruz</span>
                            <span class="text-[11px] text-slate-400">0917-123-4567</span>
                        </td>
                        <td class="py-3.5 px-5">
                            <span class="font-medium text-slate-800">Double-bed</span>
                            <span class="block text-[10px] text-slate-400">Unit 205 (Floor 2)</span>
                        </td>
                        <td class="py-3.5 px-5">
                            {{ date('M d') }} &rarr; {{ date('M d', strtotime('+1 day')) }}
                            <span class="block text-[10px] text-slate-400">1 Night</span>
                        </td>
                        <td class="py-3.5 px-5">
                            <span class="px-2 py-0.5 rounded bg-amber-50 text-amber-700 font-medium">OTC (50% Deposit)</span>
                        </td>
                        <td class="py-3.5 px-5">
                            <span class="font-bold text-slate-900">₱1,999</span>
                            <span class="block text-[10px] text-rose-600">₱999 Bal at check-in</span>
                        </td>
                        <td class="py-3.5 px-5">
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800">
                                Pending Check-in
                            </span>
                        </td>
                        <td class="py-3.5 px-5 text-right">
                            <a href="{{ route('admin.reservations.show', 1) }}" class="px-3 py-1.5 rounded-lg bg-indigo-600 text-white font-semibold text-xs hover:bg-indigo-700 transition">
                                Manage &rarr;
                            </a>
                        </td>
                    </tr>

                    <!-- Row 2 -->
                    <tr class="hover:bg-slate-50/80 transition">
                        <td class="py-3.5 px-5 font-mono font-bold text-indigo-600">IH-2026-7911</td>
                        <td class="py-3.5 px-5">
                            <span class="font-bold text-slate-900 block">Maria Santos</span>
                            <span class="text-[11px] text-slate-400">0918-987-6543</span>
                        </td>
                        <td class="py-3.5 px-5">
                            <span class="font-medium text-slate-800">Family Room</span>
                            <span class="block text-[10px] text-slate-400">Unit 301 (Floor 3)</span>
                        </td>
                        <td class="py-3.5 px-5">
                            Nov 21 &rarr; Today
                        </td>
                        <td class="py-3.5 px-5">
                            <span class="px-2 py-0.5 rounded bg-emerald-50 text-emerald-700 font-medium">E-Wallet QR</span>
                        </td>
                        <td class="py-3.5 px-5">
                            <span class="font-bold text-slate-900">₱2,999</span>
                            <span class="block text-[10px] text-emerald-600">Fully Settled</span>
                        </td>
                        <td class="py-3.5 px-5">
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                Checked In
                            </span>
                        </td>
                        <td class="py-3.5 px-5 text-right">
                            <a href="{{ route('admin.reservations.show', 2) }}" class="px-3 py-1.5 rounded-lg bg-indigo-600 text-white font-semibold text-xs hover:bg-indigo-700 transition">
                                Manage &rarr;
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
