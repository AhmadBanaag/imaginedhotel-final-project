@extends('layouts.admin')

@section('page-subtitle', 'Reservation Details')

@section('content')
<div class="space-y-6" x-data="{
    status: 'pending_checkin',
    remarks: '50% OTC deposit verified by admin.',
    showCancelModal: false,
    feedbackMessage: '',
    logs: [
        { time: '{{ date('h:i A') }}', actor: 'System', note: 'Booking IH-2026-8492 created with 50% OTC deposit (₱1,000.00).' }
    ],
    get statusBadge() {
        const map = {
            pending_checkin: { label: 'Pending Check-in (Arrival Expected Today)', classes: 'bg-amber-100 text-amber-800' },
            checked_in: { label: 'Checked In (Room 205 Occupied)', classes: 'bg-emerald-100 text-emerald-800' },
            checked_out: { label: 'Checked Out (Room 205 Released)', classes: 'bg-slate-100 text-slate-700' },
            no_show: { label: 'No-Show Logged (Room Released)', classes: 'bg-purple-100 text-purple-800' },
            overstay: { label: 'Overstay Flagged (Extra Night Billing)', classes: 'bg-rose-100 text-rose-800' },
            cancelled: { label: 'Cancelled (80% Deposit Refunded)', classes: 'bg-rose-100 text-rose-800' }
        };
        return map[this.status] || map.pending_checkin;
    },
    updateStatus(newStatus, message) {
        this.status = newStatus;
        this.feedbackMessage = message;
        const now = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        this.logs.unshift({ time: now, actor: 'Front Desk Staff', note: message });
    }
}">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <a href="{{ route('admin.reservations.index') }}" class="text-xs font-semibold text-[#06923E] hover:underline inline-flex items-center gap-1">
            &larr; Back to Reservations Desk
        </a>
        <div class="flex items-center gap-2">
            <span class="text-xs text-slate-400">Current Stay Status:</span>
            <span :class="statusBadge.classes" class="px-3 py-1 rounded-full text-xs font-bold" x-text="statusBadge.label"></span>
        </div>
    </div>

    <!-- Action Feedback Toast -->
    <div x-show="feedbackMessage" x-cloak class="bg-emerald-50 border border-emerald-200 text-emerald-900 rounded-2xl p-4 text-xs flex items-center justify-between gap-3">
        <div class="flex items-center gap-2">
            <i class="ri-checkbox-circle-line text-lg text-[#06923E]"></i>
            <span class="font-semibold" x-text="feedbackMessage"></span>
        </div>
        <button @click="feedbackMessage = ''" class="text-emerald-700 hover:text-emerald-950"><i class="ri-close-line text-base"></i></button>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <!-- Col 1: Stay & Guest Details -->
        <div class="lg:col-span-8 space-y-6">
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-2xs space-y-6">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center pb-4 border-b border-slate-100 gap-2">
                    <div>
                        <span class="text-xs text-slate-400">Booking Reference: <strong class="font-mono text-slate-700">IH-2026-8492</strong></span>
                        <h2 class="text-xl font-bold text-slate-900 mt-0.5">Juan Dela Cruz</h2>
                        <span class="text-xs text-slate-500">Phone: 0917-123-4567 | Email: guest@example.com</span>
                    </div>
                    <div class="sm:text-right">
                        <span class="text-xs text-slate-400 block">Assigned Unit</span>
                        <strong class="text-base text-[#06923E]">Room 205 (Double-bed)</strong>
                    </div>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-xs">
                    <div>
                        <span class="text-slate-400 block mb-0.5">Check-in Date</span>
                        <strong class="text-slate-900">{{ date('M d, Y') }}</strong>
                    </div>
                    <div>
                        <span class="text-slate-400 block mb-0.5">Check-out Date</span>
                        <strong class="text-slate-900">{{ date('M d, Y', strtotime('+1 day')) }}</strong>
                    </div>
                    <div>
                        <span class="text-slate-400 block mb-0.5">Total Nights</span>
                        <strong class="text-slate-900">1 Night</strong>
                    </div>
                    <div>
                        <span class="text-slate-400 block mb-0.5">Room Rate</span>
                        <strong class="text-slate-900">₱1,999.00</strong>
                    </div>
                </div>

                <div class="bg-slate-50 rounded-xl p-4 border border-slate-100 text-xs space-y-2">
                    <div class="flex justify-between">
                        <span class="text-slate-600">Total Booking Cost:</span>
                        <strong class="text-slate-900">₱1,999.00</strong>
                    </div>
                    <div class="flex justify-between text-emerald-700">
                        <span>Deposit Collected (50% OTC):</span>
                        <strong class="font-bold">₱1,000.00 (Verified)</strong>
                    </div>
                    <div class="flex justify-between text-rose-600 font-semibold">
                        <span>Balance Due from Guest at Check-in:</span>
                        <strong x-text="status === 'checked_out' ? '₱0.00 (Settled)' : '₱999.00'"></strong>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Front Desk Confirmation Remarks</label>
                    <textarea x-model="remarks" rows="2" class="w-full text-xs rounded-xl border-slate-200 focus:ring-[#EDC92C] focus:border-[#EDC92C]"></textarea>
                </div>
            </div>

            <!-- Activity Timeline -->
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-2xs space-y-4">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-500">Front Desk Activity Log</h3>
                <ul class="space-y-3 text-xs">
                    <template x-for="(entry, idx) in logs" :key="idx">
                        <li class="flex items-start gap-3 pb-3 border-b border-slate-100 last:border-0 last:pb-0">
                            <span class="px-2 py-0.5 rounded-md bg-slate-100 text-slate-600 font-mono text-[10px] shrink-0" x-text="entry.time"></span>
                            <div>
                                <strong class="text-slate-800" x-text="entry.actor + ':'"></strong>
                                <span class="text-slate-600" x-text="entry.note"></span>
                            </div>
                        </li>
                    </template>
                </ul>
            </div>
        </div>

        <!-- Col 2: Action Control Panel -->
        <div class="lg:col-span-4 space-y-4">
            <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-2xs space-y-3">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-500 pb-2 border-b border-slate-100">
                    Front Desk Status Actions
                </h3>

                <button type="button" @click="updateStatus('checked_in', 'Guest Juan Dela Cruz checked into Room 205. Room marked as Booked.')"
                    class="w-full py-2.5 px-4 rounded-xl bg-[#06923E] hover:bg-[#057a34] text-white font-semibold text-xs flex items-center justify-center gap-2 transition shadow-2xs">
                    <i class="ri-login-box-line text-sm"></i> Check In Guest
                </button>

                <button type="button" @click="updateStatus('checked_out', 'Guest checked out and balance settled. Room 205 released.')"
                    class="w-full py-2.5 px-4 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-semibold text-xs flex items-center justify-center gap-2 transition">
                    <i class="ri-logout-box-line text-sm"></i> Check Out &amp; Release Room
                </button>

                <button type="button" @click="updateStatus('no_show', 'Logged as No-Show. Room 205 released back to available inventory.')"
                    class="w-full py-2.5 px-4 rounded-xl bg-amber-50 hover:bg-amber-100 text-amber-800 font-semibold text-xs border border-amber-200 flex items-center justify-center gap-2 transition">
                    <i class="ri-user-unfollow-line text-sm"></i> Log No-Show (Didn't check in)
                </button>

                <button type="button" @click="updateStatus('overstay', 'Logged as Overstay. Extra night charge flagged for settlement.')"
                    class="w-full py-2.5 px-4 rounded-xl bg-purple-50 hover:bg-purple-100 text-purple-800 font-semibold text-xs border border-purple-200 flex items-center justify-center gap-2 transition">
                    <i class="ri-time-line text-sm"></i> Log Overstay (Didn't check out)
                </button>

                <hr class="border-slate-100 my-2">

                <a href="{{ route('admin.payments.invoice', 1) }}" class="w-full py-2.5 px-4 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 font-semibold text-xs flex items-center justify-center gap-2 transition">
                    <i class="ri-printer-line"></i> Generate Guest Invoice
                </a>

                <button type="button" @click="showCancelModal = true" class="w-full py-2.5 px-4 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-700 font-semibold text-xs border border-rose-200 flex items-center justify-center gap-2 transition">
                    <i class="ri-close-circle-line"></i> Cancel Reservation (20% fee)
                </button>
            </div>
        </div>
    </div>

    <!-- Cancellation Confirmation Modal -->
    <div x-show="showCancelModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 p-4">
        <div @click.outside="showCancelModal = false" class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl space-y-4">
            <div class="w-12 h-12 bg-rose-100 text-rose-600 rounded-xl flex items-center justify-center text-2xl">
                <i class="ri-alert-line"></i>
            </div>
            <h3 class="text-lg font-bold text-slate-900">Confirm Booking Cancellation?</h3>
            <p class="text-xs text-slate-600 leading-relaxed">
                Cancelling deducts a <strong>20% administrative fee</strong> from the guest's paid deposit and returns 80%.
            </p>
            <div class="bg-slate-50 p-3 rounded-xl border border-slate-200 text-xs space-y-1">
                <div class="flex justify-between"><span>Deposit Paid:</span> <strong>₱1,000.00</strong></div>
                <div class="flex justify-between text-rose-600"><span>20% Cancellation Fee:</span> <strong>-₱200.00</strong></div>
                <hr class="border-slate-200 my-1">
                <div class="flex justify-between text-emerald-700 font-bold"><span>80% Refund Amount:</span> <strong>₱800.00</strong></div>
            </div>
            <div class="flex gap-2 pt-2">
                <button type="button" @click="showCancelModal = false" class="flex-1 py-2.5 rounded-xl border border-slate-200 text-slate-700 text-xs font-semibold hover:bg-slate-50">Keep Booking</button>
                <button type="button" @click="showCancelModal = false; updateStatus('cancelled', 'Booking cancelled. Room 205 released and ₱800.00 (80%) refund logged.')"
                    class="flex-1 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-semibold">Confirm Cancellation</button>
            </div>
        </div>
    </div>
</div>
@endsection
