@extends('layouts.admin')

@section('page-title', 'Payments & E-Wallet Verification Queue')
@section('page-subtitle', 'Monitor incoming 50% OTC downpayments and verify GCash / Maya E-wallet QR codes')

@section('content')
<div class="space-y-6">
    <!-- Top Summary Metrics -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs">
            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">Today's Total Collected</span>
            <div class="text-2xl font-bold text-slate-900 mt-1">₱18,990.00</div>
            <span class="text-[11px] text-emerald-600 font-medium">OTC Deposits + E-Wallet transactions</span>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs">
            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">Pending E-Wallet Approvals</span>
            <div class="text-2xl font-bold text-amber-600 mt-1">2 Queue</div>
            <span class="text-[11px] text-slate-400">Requires receptionist reference check</span>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs">
            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">Refunds Processed (80%)</span>
            <div class="text-2xl font-bold text-rose-600 mt-1">₱1,600.00</div>
            <span class="text-[11px] text-slate-400">2 cancellations (20% fee retained)</span>
        </div>
    </div>

    <!-- Payments Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-2xs overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex justify-between items-center">
            <h3 class="font-bold text-slate-900 text-sm">Recent Transactions &amp; Verification Ledger</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 uppercase tracking-wider font-semibold">
                        <th class="py-3.5 px-5">Receipt Ref</th>
                        <th class="py-3.5 px-5">Guest Name</th>
                        <th class="py-3.5 px-5">Method</th>
                        <th class="py-3.5 px-5">Type</th>
                        <th class="py-3.5 px-5">Amount</th>
                        <th class="py-3.5 px-5">Status</th>
                        <th class="py-3.5 px-5 text-right">Verification Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    <!-- Row 1: E-Wallet Needs verification -->
                    <tr class="hover:bg-slate-50/80 transition bg-amber-50/20">
                        <td class="py-3.5 px-5 font-mono font-bold text-slate-900">REF-849102</td>
                        <td class="py-3.5 px-5 font-semibold text-slate-900">Carl James Ayag</td>
                        <td class="py-3.5 px-5">
                            <span class="inline-flex items-center gap-1 font-semibold text-indigo-700">
                                <i class="ri-qr-code-line"></i> GCash QR
                            </span>
                        </td>
                        <td class="py-3.5 px-5">100% Full Payment</td>
                        <td class="py-3.5 px-5 font-bold text-slate-900">₱2,999.00</td>
                        <td class="py-3.5 px-5">
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800">
                                Pending Approval
                            </span>
                        </td>
                        <td class="py-3.5 px-5 text-right space-x-1.5">
                            <button onclick="alert('E-Wallet payment REF-849102 verified!')" class="px-3 py-1 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-lg text-xs">
                                Approve QR
                            </button>
                        </td>
                    </tr>

                    <!-- Row 2: OTC 50% Verified -->
                    <tr class="hover:bg-slate-50/80 transition">
                        <td class="py-3.5 px-5 font-mono font-bold text-slate-900">REF-201948</td>
                        <td class="py-3.5 px-5 font-semibold text-slate-900">Juan Dela Cruz</td>
                        <td class="py-3.5 px-5">
                            <span class="inline-flex items-center gap-1 font-semibold text-slate-700">
                                <i class="ri-wallet-3-line"></i> Over The Counter
                            </span>
                        </td>
                        <td class="py-3.5 px-5">50% Cash Downpayment</td>
                        <td class="py-3.5 px-5 font-bold text-slate-900">₱1,000.00</td>
                        <td class="py-3.5 px-5">
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                Verified
                            </span>
                        </td>
                        <td class="py-3.5 px-5 text-right">
                            <a href="{{ route('admin.payments.invoice', 1) }}" class="text-indigo-600 hover:underline font-semibold">
                                View Invoice
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
