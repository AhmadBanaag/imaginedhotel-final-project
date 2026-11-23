@extends('layouts.admin')

@section('page-title', 'Official Guest Invoice')
@section('page-subtitle', 'Final guest checkout billing statement and payment verification record')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.payments.index') }}" class="text-xs font-semibold text-indigo-600 hover:underline">
            &larr; Back to Payment Ledger
        </a>
        <button onclick="window.print()" class="px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white font-semibold text-xs rounded-xl shadow-2xs transition flex items-center gap-1.5">
            <i class="ri-printer-line"></i> Print Official Invoice
        </button>
    </div>

    <!-- Printable Invoice Sheet -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-xl p-8 sm:p-12 space-y-8" id="invoiceSheet">
        <!-- Top Invoice Header -->
        <div class="flex justify-between items-start pb-6 border-b border-slate-200">
            <div>
                <div class="flex items-center gap-2">
                    <div class="w-10 h-10 rounded-xl bg-indigo-600 text-white flex items-center justify-center font-bold text-lg">IH</div>
                    <div>
                        <h2 class="text-xl font-bold tracking-tight text-slate-900">ImaginedHotel</h2>
                        <span class="text-xs text-slate-500">UICTO, USM, Kabacan</span>
                    </div>
                </div>
            </div>
            <div class="text-right">
                <span class="text-xs uppercase font-bold text-slate-400 block tracking-wider">Official Invoice</span>
                <span class="text-lg font-mono font-bold text-slate-900">INV-2026-0849</span>
                <span class="text-xs text-slate-400 block mt-0.5">Date: {{ date('F d, Y') }}</span>
            </div>
        </div>

        <!-- Bill To & Stay Summary -->
        <div class="grid grid-cols-2 gap-6 text-xs">
            <div>
                <span class="text-slate-400 uppercase font-semibold tracking-wider block mb-1">Billed To</span>
                <strong class="text-sm font-bold text-slate-900 block">Juan Dela Cruz</strong>
                <span class="text-slate-500">Contact: 0917-123-4567</span><br>
                <span class="text-slate-500">Email: guest@example.com</span>
            </div>
            <div class="text-right">
                <span class="text-slate-400 uppercase font-semibold tracking-wider block mb-1">Stay Details</span>
                <strong class="text-sm font-bold text-slate-900 block">Room 205 (Double-bed)</strong>
                <span class="text-slate-500">Check-in: {{ date('M d, Y') }} (2:00 PM)</span><br>
                <span class="text-slate-500">Check-out: {{ date('M d, Y', strtotime('+1 day')) }} (12:00 PM)</span>
            </div>
        </div>

        <!-- Line Items Table -->
        <div>
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-y border-slate-200 text-slate-600 uppercase font-semibold">
                        <th class="py-3 px-4">Description</th>
                        <th class="py-3 px-4 text-center">Nights</th>
                        <th class="py-3 px-4 text-right">Rate</th>
                        <th class="py-3 px-4 text-right">Amount</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    <tr>
                        <td class="py-3 px-4">
                            <strong>Double-bed Room Accommodation</strong>
                            <span class="block text-[11px] text-slate-400">Includes AC, Free WiFi, TV, Toiletries</span>
                        </td>
                        <td class="py-3 px-4 text-center">1</td>
                        <td class="py-3 px-4 text-right">₱1,999.00</td>
                        <td class="py-3 px-4 text-right font-semibold">₱1,999.00</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Totals & Settled Balance -->
        <div class="flex justify-end pt-4 border-t border-slate-200">
            <div class="w-64 space-y-2 text-xs">
                <div class="flex justify-between text-slate-600">
                    <span>Subtotal:</span>
                    <span>₱1,999.00</span>
                </div>
                <div class="flex justify-between text-emerald-700 font-semibold">
                    <span>Deposit Paid (50% OTC):</span>
                    <span>-₱1,000.00</span>
                </div>
                <div class="flex justify-between text-slate-600">
                    <span>Balance Paid at Check-in:</span>
                    <span>-₱999.00</span>
                </div>
                <hr class="border-slate-200 my-1">
                <div class="flex justify-between text-base font-bold text-slate-900">
                    <span>Total Balance Due:</span>
                    <span class="text-emerald-700">₱0.00 (PAID)</span>
                </div>
            </div>
        </div>

        <!-- Signature Lines -->
        <div class="grid grid-cols-2 gap-8 pt-12 border-t border-slate-200 text-xs">
            <div>
                <div class="border-b border-slate-400 w-48 mb-1"></div>
                <span class="text-slate-500 font-medium">Guest Signature</span>
            </div>
            <div class="text-right">
                <div class="border-b border-slate-400 w-48 ml-auto mb-1"></div>
                <span class="text-slate-500 font-medium">Authorized Front Desk Officer</span>
            </div>
        </div>
    </div>
</div>
@endsection
