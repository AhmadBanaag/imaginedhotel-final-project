@extends('layouts.hotel')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">My Reservations &amp; Stay History</h1>
            <p class="text-sm text-slate-500 mt-1">Review your current, upcoming, and past hotel room bookings.</p>
        </div>
        <div>
            <a href="{{ route('rooms.index') }}" class="px-4 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold shadow-2xs transition inline-flex items-center gap-1.5">
                <i class="ri-add-line"></i> New Booking
            </a>
        </div>
    </div>  

    <!-- Reservations Table Card -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-2xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 uppercase tracking-wider font-semibold">
                        <th class="py-4 px-6">Booking Code</th>
                        <th class="py-4 px-6">Room Category</th>
                        <th class="py-4 px-6">Check-in / Check-out</th>
                        <th class="py-4 px-6">Payment Method</th>
                        <th class="py-4 px-6">Total / Paid</th>
                        <th class="py-4 px-6">Status</th>
                        <th class="py-4 px-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    <!-- Reservation 1: Active -->
                    <tr class="hover:bg-slate-50/80 transition">
                        <td class="py-4 px-6 font-mono font-bold text-indigo-600">IH-2026-8492</td>
                        <td class="py-4 px-6 font-semibold text-slate-900">
                            Double-bed Room (Unit 205)
                        </td>
                        <td class="py-4 px-6">
                            {{ date('M d, Y') }} &rarr; {{ date('M d, Y', strtotime('+1 day')) }}
                        </td>
                        <td class="py-4 px-6">
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-slate-100 text-slate-700 font-medium">
                                <i class="ri-wallet-3-line"></i> 50% OTC Deposit
                            </span>
                        </td>
                        <td class="py-4 px-6">
                            <div class="font-bold text-slate-900">₱1,999</div>
                            <span class="text-[10px] text-emerald-600">Paid: ₱1,000 (Bal: ₱999)</span>
                        </td>
                        <td class="py-4 px-6">
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                Confirmed
                            </span>
                        </td>
                        <td class="py-4 px-6 text-right space-x-2">
                            <a href="{{ route('guest.reservations.show', 1) }}" class="text-indigo-600 font-semibold hover:underline">Details</a>
                            <a href="{{ route('reservations.confirmation') }}" class="text-slate-500 hover:text-slate-900">Receipt</a>
                        </td>
                    </tr>

                    <!-- Reservation 2: Past Stays -->
                    <tr class="hover:bg-slate-50/80 transition">
                        <td class="py-4 px-6 font-mono font-bold text-slate-500">IH-2026-1029</td>
                        <td class="py-4 px-6 font-semibold text-slate-900">
                            Single-bed Room (Unit 102)
                        </td>
                        <td class="py-4 px-6">
                            Nov 10, 2026 &rarr; Nov 12, 2026
                        </td>
                        <td class="py-4 px-6">
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-slate-100 text-slate-700 font-medium">
                                <i class="ri-qr-code-line"></i> E-Wallet QR
                            </span>
                        </td>
                        <td class="py-4 px-6">
                            <div class="font-bold text-slate-900">₱1,998</div>
                            <span class="text-[10px] text-slate-500">Fully Settled</span>
                        </td>
                        <td class="py-4 px-6">
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600">
                                Checked Out
                            </span>
                        </td>
                        <td class="py-4 px-6 text-right">
                            <a href="{{ route('guest.reservations.show', 2) }}" class="text-slate-600 font-semibold hover:underline">View History</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
