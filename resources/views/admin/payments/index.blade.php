@extends('layouts.admin')

@section('page-subtitle', 'Payments & QR Verification')

@section('content')
<div class="space-y-6" x-data="{
    viewInvoice: false,
    activeFilter: 'all',
    searchQuery: '',
    selectedTx: false,
    toastMessage: '',
    transactions: [
        {
            id: 1,
            ref: 'REF-849102',
            booking: 'IH-2026-8492',
            guest: 'Carl James Ayag',
            method: 'GCash QR',
            methodIcon: 'ri-qr-code-line',
            type: '100% Full Payment',
            amount: 2999,
            status: 'pending',
            date: '{{ date('M d, Y h:i A') }}'
        },
        {
            id: 2,
            ref: 'REF-849215',
            booking: 'IH-2026-8504',
            guest: 'Mark Villanueva',
            method: 'Maya QR',
            methodIcon: 'ri-qr-code-line',
            type: '100% Full Payment',
            amount: 1998,
            status: 'pending',
            date: '{{ date('M d, Y h:i A', strtotime('-25 mins')) }}'
        },
        {
            id: 3,
            ref: 'REF-201948',
            booking: 'IH-2026-8492',
            guest: 'Juan Dela Cruz',
            method: 'Over The Counter',
            methodIcon: 'ri-wallet-3-line',
            type: '50% Cash Downpayment',
            amount: 1000,
            status: 'verified',
            date: '{{ date('M d, Y h:i A', strtotime('-1 hour')) }}'
        },
        {
            id: 4,
            ref: 'REF-774120',
            booking: 'IH-2026-7911',
            guest: 'Maria Santos',
            method: 'GCash QR',
            methodIcon: 'ri-qr-code-line',
            type: '100% Full Payment',
            amount: 5998,
            status: 'verified',
            date: 'Nov 24, 2026 02:15 PM'
        },
        {
            id: 5,
            ref: 'REF-661094',
            booking: 'IH-2026-8398',
            guest: 'Paolo Reyes',
            method: 'OTC Refund',
            methodIcon: 'ri-refund-2-line',
            type: '80% Cancellation Refund (20% Fee Retained)',
            amount: 800,
            status: 'refunded',
            date: 'Nov 23, 2026 04:40 PM'
        }
    ],
    get filteredTransactions() {
        const q = this.searchQuery.trim().toLowerCase();
        return this.transactions.filter(tx => {
            const matchFilter = this.activeFilter === 'all' || tx.status === this.activeFilter;
            const matchSearch = !q || tx.ref.toLowerCase().includes(q) || tx.guest.toLowerCase().includes(q) || tx.booking.toLowerCase().includes(q);
            return matchFilter && matchSearch;
        });
    },
    get totalCollected() {
        return this.transactions.filter(t => t.status === 'verified').reduce((sum, t) => sum + t.amount, 0);
    },
    get pendingCount() {
        return this.transactions.filter(t => t.status === 'pending').length;
    },
    get totalRefunded() {
        return this.transactions.filter(t => t.status === 'refunded').reduce((sum, t) => sum + t.amount, 0);
    },
    peso(val) {
        return '₱' + Number(val).toLocaleString('en-PH', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    },
    approveSelected() {
        if (!this.selectedTx) return;
        this.selectedTx.status = 'verified';
        this.toastMessage = 'Payment ' + this.selectedTx.ref + ' (' + this.peso(this.selectedTx.amount) + ') marked as Verified.';
        this.selectedTx = false;
    },
    rejectSelected() {
        if (!this.selectedTx) return;
        this.selectedTx.status = 'rejected';
        this.toastMessage = 'Payment ' + this.selectedTx.ref + ' flagged as Invalid Reference.';
        this.selectedTx = false;
    }
}">
    <!-- Top Summary Metrics -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs">
            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">Verified Collected</span>
            <div class="text-2xl font-bold text-[#06923E] mt-1" x-text="peso(totalCollected)"></div>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs">
            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">Pending QR Approvals</span>
            <div class="text-2xl font-bold text-amber-600 mt-1" x-text="pendingCount"></div>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs">
            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">Refunds Processed (80%)</span>
            <div class="text-2xl font-bold text-rose-600 mt-1" x-text="peso(totalRefunded)"></div>
        </div>
    </div>

    <div x-show="toastMessage" x-cloak class="bg-emerald-50 border border-emerald-200 text-emerald-900 rounded-2xl p-4 text-xs flex items-center justify-between">
        <div class="flex items-center gap-2">
            <i class="ri-checkbox-circle-line text-lg text-[#06923E]"></i>
            <span class="font-semibold" x-text="toastMessage"></span>
        </div>
        <button type="button" @click="toastMessage = ''" class="text-emerald-700 hover:text-emerald-950"><i class="ri-close-line text-base"></i></button>
    </div>

    <!-- Filter & Search Bar -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex flex-wrap gap-1.5 text-xs">
            <button @click="activeFilter = 'all'" :class="activeFilter === 'all' ? 'bg-slate-900 text-white font-bold' : 'bg-slate-100 text-slate-700'" class="px-3 py-1.5 rounded-lg transition">All Ledger</button>
            <button @click="activeFilter = 'pending'" :class="activeFilter === 'pending' ? 'bg-[#EDC92C] text-white font-bold' : 'bg-slate-100 text-slate-700'" class="px-3 py-1.5 rounded-lg transition">Pending QR</button>
            <button @click="activeFilter = 'verified'" :class="activeFilter === 'verified' ? 'bg-[#06923E] text-white font-bold' : 'bg-slate-100 text-slate-700'" class="px-3 py-1.5 rounded-lg transition">Verified</button>
            <button @click="activeFilter = 'refunded'" :class="activeFilter === 'refunded' ? 'bg-rose-600 text-white font-bold' : 'bg-slate-100 text-slate-700'" class="px-3 py-1.5 rounded-lg transition">Refunded (80%)</button>
        </div>
        <div class="relative w-full md:w-72">
            <i class="ri-search-line absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
            <input type="text" x-model="searchQuery" placeholder="Search ref, booking code, or guest..." class="w-full pl-8 pr-3 py-1.5 text-xs rounded-xl border-slate-200 focus:ring-[#EDC92C] focus:border-[#EDC92C]">
        </div>
    </div>

    <!-- Payments Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-2xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 uppercase tracking-wider font-semibold">
                        <th class="py-3.5 px-5">Receipt Ref</th>
                        <th class="py-3.5 px-5">Guest / Booking</th>
                        <th class="py-3.5 px-5">Method</th>
                        <th class="py-3.5 px-5">Type</th>
                        <th class="py-3.5 px-5">Amount</th>
                        <th class="py-3.5 px-5">Status</th>
                        <th class="py-3.5 px-5 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    <template x-for="tx in filteredTransactions" :key="tx.id">
                        <tr class="hover:bg-slate-50/80 transition" :class="tx.status === 'pending' ? 'bg-amber-50/25' : ''">
                            <td class="py-3.5 px-5 font-mono font-bold text-[#06923E]">
                                <span x-text="tx.ref"></span>
                                <span class="block font-sans font-normal text-[10px] text-slate-400" x-text="tx.date"></span>
                            </td>
                            <td class="py-3.5 px-5">
                                <span class="font-semibold text-slate-900 block" x-text="tx.guest"></span>
                                <span class="font-mono text-[10px] text-slate-400" x-text="tx.booking"></span>
                            </td>
                            <td class="py-3.5 px-5">
                                <span class="inline-flex items-center gap-1 font-semibold text-slate-800">
                                    <i :class="tx.methodIcon" class="text-[#06923E]"></i>
                                    <span x-text="tx.method"></span>
                                </span>
                            </td>
                            <td class="py-3.5 px-5" x-text="tx.type"></td>
                            <td class="py-3.5 px-5 font-bold text-slate-900" x-text="peso(tx.amount)"></td>
                            <td class="py-3.5 px-5">
                                <span x-show="tx.status === 'pending'" class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800">Pending Approval</span>
                                <span x-show="tx.status === 'verified'" class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">Verified</span>
                                <span x-show="tx.status === 'refunded'" class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-rose-100 text-rose-800">Refunded (80%)</span>
                                <span x-show="tx.status === 'rejected'" class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-200 text-slate-700">Flagged Invalid</span>
                            </td>
                            <td class="py-3.5 px-5 text-right whitespace-nowrap">
                                <button x-show="tx.status === 'pending'" type="button" @click="selectedTx = tx" class="px-3 py-1.5 bg-[#06923E] hover:bg-[#057a34] text-white font-semibold rounded-lg text-xs transition">
                                    Verify QR
                                </button>
                                <button x-show="tx.status !== 'pending'" type="button" @click="viewInvoice = true" class="text-[#06923E] hover:underline font-semibold">
                                    View Invoice &rarr;
                                </button>
                            </td>
                        </tr>
                    </template>
                    <tr x-show="filteredTransactions.length === 0">
                        <td colspan="7" class="py-10 text-center text-slate-400">No payment records match your filter.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- QR Verification Modal -->
    <div x-show="selectedTx" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div @click.outside="selectedTx = false" class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <h3 class="text-base font-bold text-slate-900">Verify E-Wallet QR Payment</h3>
                <button type="button" @click="selectedTx = false" class="text-slate-400 hover:text-slate-700"><i class="ri-close-line text-xl"></i></button>
            </div>
            <div class="bg-slate-50 rounded-xl p-4 border border-slate-200 text-xs space-y-2">
                <div class="flex justify-between"><span class="text-slate-500">Reference No:</span> <strong class="font-mono text-slate-900" x-text="selectedTx?.ref"></strong></div>
                <div class="flex justify-between"><span class="text-slate-500">Guest:</span> <strong class="text-slate-900" x-text="selectedTx?.guest"></strong></div>
                <div class="flex justify-between"><span class="text-slate-500">Booking Code:</span> <strong class="font-mono text-slate-900" x-text="selectedTx?.booking"></strong></div>
                <div class="flex justify-between"><span class="text-slate-500">Channel:</span> <strong class="text-slate-900" x-text="selectedTx?.method"></strong></div>
                <div class="flex justify-between text-sm pt-1 border-t border-slate-200"><span class="font-semibold text-slate-700">Amount Submitted:</span> <strong class="text-[#06923E]" x-text="selectedTx ? peso(selectedTx.amount) : ''"></strong></div>
            </div>
            <p class="text-[11px] text-slate-500">Confirm that the reference number and amount match your GCash / Maya merchant settlement ledger before approving.</p>
            <div class="flex gap-2 pt-1">
                <button type="button" @click="rejectSelected()" class="px-4 py-2.5 rounded-xl border border-rose-200 bg-rose-50 text-rose-700 text-xs font-semibold hover:bg-rose-100">Flag Invalid</button>
                <button type="button" @click="approveSelected()" class="flex-1 py-2.5 rounded-xl bg-[#06923E] hover:bg-[#057a34] text-white text-xs font-bold">Approve &amp; Verify Payment</button>
            </div>
        </div>
    </div>
    
    <!-- View Invoice Modal -->  
    <div x-show="viewInvoice" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 p-4">
        <div @click.outside="viewInvoice = false" class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl space-y-4" id="invoiceSheet">
                    <div class="flex items-center justify-between print:hidden">
                        <button type="button" onclick="window.print()" class="px-4 py-2 bg-slate-900 hover:bg-[#06923E] text-white font-semibold text-xs rounded-xl shadow-2xs transition flex items-center gap-1.5">
                            <i class="ri-printer-line"></i> Print Official Invoice
                        </button>
                        <button type="button" @click="viewInvoice = false" class="text-slate-400 hover:text-slate-700"><i class="ri-close-line text-xl"></i></button>
                    </div>
                    <div class="flex flex-col sm:flex-row justify-between items-start gap-4 pb-6 border-b border-slate-200">
                    <div class="flex items-center gap-3 pt-3">
                         <a href="{{ route('landing') }}" class="flex items-center gap-2 group">
                         <i class="ri-hotel-line text-4xl text-[#EDC92C]"></i>
                         <span class="text-xl font-bold tracking-tight">ImaginedHotel</span>
                         </a>
                    </div>
                    <div class="sm:text-right">
                        <span class="text-xs uppercase font-bold text-slate-400 block tracking-wider">Official Invoice</span>
                        <span class="text-lg font-mono font-bold text-slate-900">INV-2026-{{ str_pad((string) ($id ?? 849), 4, '0', STR_PAD_LEFT) }}</span>
                        <span class="text-xs text-slate-400 block mt-0.5">Date: {{ date('F d, Y') }}</span>
                    </div>
                </div>

                <!-- Bill To & Stay Summary -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-xs">
                    <div>
                        <span class="text-slate-400 uppercase font-semibold tracking-wider block mb-1">Billed To</span>
                        <strong class="text-sm font-bold text-slate-900 block">Juan Dela Cruz</strong>
                        <span class="text-slate-500">Contact: 0917-123-4567</span><br>
                        <span class="text-slate-500">Email: guest@example.com</span>
                    </div>
                    <div class="sm:text-right">
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
                        <div class="flex justify-between text-[#06923E] font-semibold">
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
                            <span class="text-[#06923E]">₱0.00 (PAID)</span>
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
</div>
@endsection
