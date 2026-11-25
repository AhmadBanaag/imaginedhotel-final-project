@extends('layouts.admin')

@section('page-subtitle', 'Walk-in Booking')

@section('content')
<div class="max-w-5xl mx-auto space-y-6" x-data="{
    firstName: '',
    lastName: '',
    phone: '',
    email: '',
    selectedRoomId: '101',
    checkIn: '{{ date('Y-m-d') }}',
    checkOut: '{{ date('Y-m-d', strtotime('+1 day')) }}',
    paymentType: 'otc_50',
    remarks: '',
    submitted: false,
    generatedCode: '',
    rooms: [
        { id: '101', label: 'Room 101', category: 'Single-bed Room', rate: 999 },
        { id: '103', label: 'Room 103', category: 'Single-bed Room', rate: 999 },
        { id: '202', label: 'Room 202', category: 'Double-bed Room', rate: 1999 },
        { id: '203', label: 'Room 203', category: 'Double-bed Room', rate: 1999 },
        { id: '302', label: 'Room 302', category: 'Family Room', rate: 2999 },
        { id: '401', label: 'Room 401', category: 'Superior Room (VIP)', rate: 4999 }
    ],
    get selectedRoom() {
        return this.rooms.find(r => r.id === this.selectedRoomId) || this.rooms[0];
    },
    get nights() {
        const start = new Date(this.checkIn);
        const end = new Date(this.checkOut);
        if (isNaN(start) || isNaN(end)) return 1;
        const diff = Math.round((end - start) / 86400000);
        return diff > 0 ? diff : 1;
    },
    get totalCost() {
        return this.selectedRoom.rate * this.nights;
    },
    get amountPaidNow() {
        return this.paymentType === 'full_paid' ? this.totalCost : Math.round(this.totalCost * 0.5);
    },
    get balanceDue() {
        return this.totalCost - this.amountPaidNow;
    },
    formatPeso(val) {
        return '₱' + Number(val).toLocaleString('en-PH');
    },
    submitWalkIn() {
        this.generatedCode = 'IH-2026-' + Math.floor(1000 + Math.random() * 9000);
        this.submitted = true;
    }
}">
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.reservations.index') }}" class="text-xs font-semibold text-[#06923E] hover:underline inline-flex items-center gap-1">
            &larr; Back to Reservations Desk
        </a>
        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-[#EDC92C]/20 text-slate-800">
            Direct Reception Check-In Flow
        </span>
    </div>

    <!-- Confirmation Banner -->
    <div x-show="submitted" x-cloak class="bg-emerald-50 border border-emerald-200 rounded-2xl p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex items-start gap-3">
            <div class="w-10 h-10 rounded-xl bg-[#06923E] text-white flex items-center justify-center text-xl shrink-0">
                <i class="ri-checkbox-circle-line"></i>
            </div>
            <div>
                <h3 class="text-sm font-bold text-emerald-950">Walk-in Reservation Registered (<span class="font-mono" x-text="generatedCode"></span>)</h3>
                <p class="text-xs text-emerald-800 mt-0.5">
                    <span x-text="firstName + ' ' + lastName"></span> assigned to <strong x-text="selectedRoom.label + ' (' + selectedRoom.category + ')'"></strong>
                    for <strong x-text="nights + (nights === 1 ? ' night' : ' nights')"></strong>.
                    Collected <strong x-text="formatPeso(amountPaidNow)"></strong>.
                </p>
            </div>
        </div>
        <div class="flex items-center gap-2 shrink-0">
            <a href="{{ route('admin.reservations.index') }}" class="px-3.5 py-2 rounded-xl bg-white border border-emerald-200 text-emerald-900 text-xs font-semibold hover:bg-emerald-100">
                View Desk Ledger
            </a>
            <button type="button" @click="submitted = false; firstName = ''; lastName = ''; phone = ''; email = ''; remarks = '';" class="px-3.5 py-2 rounded-xl bg-[#06923E] text-white text-xs font-semibold hover:bg-[#057a34]">
                New Walk-in
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <!-- Form Column -->
        <div class="lg:col-span-8 bg-white rounded-2xl border border-slate-200 shadow-2xs p-6 sm:p-8 space-y-6">
            <h2 class="text-lg font-bold text-slate-900 pb-3 border-b border-slate-100">Walk-in Guest Registration Form</h2>

            <form @submit.prevent="submitWalkIn" class="space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">First Name</label>
                        <input type="text" x-model="firstName" required placeholder="Guest First Name" class="w-full text-sm rounded-xl border-slate-200 focus:ring-[#EDC92C] focus:border-[#EDC92C]">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Last Name</label>
                        <input type="text" x-model="lastName" required placeholder="Guest Last Name" class="w-full text-sm rounded-xl border-slate-200 focus:ring-[#EDC92C] focus:border-[#EDC92C]">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Phone Number</label>
                        <input type="tel" x-model="phone" required placeholder="e.g. 0917-000-0000" class="w-full text-sm rounded-xl border-slate-200 focus:ring-[#EDC92C] focus:border-[#EDC92C]">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Email (Optional)</label>
                        <input type="email" x-model="email" placeholder="e.g. guest@example.com" class="w-full text-sm rounded-xl border-slate-200 focus:ring-[#EDC92C] focus:border-[#EDC92C]">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Available Room Unit</label>
                        <select x-model="selectedRoomId" class="w-full text-sm rounded-xl border-slate-200 focus:ring-[#EDC92C] focus:border-[#EDC92C]">
                            <template x-for="room in rooms" :key="room.id">
                                <option :value="room.id" x-text="room.label + ' (' + room.category.split(' ')[0] + ' - ' + formatPeso(room.rate) + ')'"></option>
                            </template>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Check-in Date</label>
                        <input type="date" x-model="checkIn" min="{{ date('Y-m-d') }}" class="w-full text-sm rounded-xl border-slate-200 focus:ring-[#EDC92C] focus:border-[#EDC92C]">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Check-out Date</label>
                        <input type="date" x-model="checkOut" :min="checkIn" class="w-full text-sm rounded-xl border-slate-200 focus:ring-[#EDC92C] focus:border-[#EDC92C]">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Payment Received at Reception</label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <label :class="paymentType === 'otc_50' ? 'border-[#EDC92C] bg-[#EDC92C]/10' : 'border-slate-200 bg-slate-50'" class="p-3.5 border-2 rounded-xl flex items-center gap-2.5 cursor-pointer transition">
                            <input type="radio" x-model="paymentType" value="otc_50" class="text-[#06923E] focus:ring-[#06923E]">
                            <div>
                                <span class="text-xs font-bold text-slate-900 block">50% Cash Downpayment</span>
                                <span class="text-[11px] text-slate-500">Collect <span x-text="formatPeso(Math.round(totalCost * 0.5))"></span> now</span>
                            </div>
                        </label>
                        <label :class="paymentType === 'full_paid' ? 'border-[#06923E] bg-emerald-50' : 'border-slate-200 bg-slate-50'" class="p-3.5 border-2 rounded-xl flex items-center gap-2.5 cursor-pointer transition">
                            <input type="radio" x-model="paymentType" value="full_paid" class="text-[#06923E] focus:ring-[#06923E]">
                            <div>
                                <span class="text-xs font-bold text-slate-900 block">100% Full Payment Settled</span>
                                <span class="text-[11px] text-slate-500">Collect <span x-text="formatPeso(totalCost)"></span> now</span>
                            </div>
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Front Desk Confirmation Remarks</label>
                    <textarea x-model="remarks" rows="2" placeholder="e.g. Verified walk-in guest ID, issued room key card." class="w-full text-sm rounded-xl border-slate-200 focus:ring-[#EDC92C] focus:border-[#EDC92C]"></textarea>
                </div>

                <div class="pt-4 border-t border-slate-100 flex gap-3">
                    <button type="submit" class="flex-1 py-3 rounded-xl bg-[#06923E] hover:bg-[#057a34] text-white font-bold text-xs transition inline-flex items-center justify-center gap-1.5">
                        <i class="ri-key-2-line"></i> Register Walk-in Guest &amp; Issue Key
                    </button>
                    <a href="{{ route('admin.reservations.index') }}" class="py-3 px-5 rounded-xl border border-slate-200 text-slate-700 text-xs font-semibold hover:bg-slate-50 transition">
                        Cancel
                    </a>
                </div>
            </form>
        </div>

        <!-- Live Billing Summary -->
        <div class="lg:col-span-4">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-2xs p-6 space-y-4 sticky top-24">
                <h3 class="text-sm font-bold text-slate-900 pb-3 border-b border-slate-100">Walk-in Billing Summary</h3>

                <div class="space-y-2.5 text-xs">
                    <div class="flex justify-between">
                        <span class="text-slate-500">Assigned Unit</span>
                        <span class="font-bold text-slate-900" x-text="selectedRoom.label"></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Category</span>
                        <span class="font-semibold text-slate-800" x-text="selectedRoom.category"></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Nightly Rate</span>
                        <span class="font-semibold text-slate-900" x-text="formatPeso(selectedRoom.rate)"></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Duration</span>
                        <span class="font-semibold text-slate-900" x-text="nights + (nights === 1 ? ' Night' : ' Nights')"></span>
                    </div>
                    <hr class="border-slate-100 my-1">
                    <div class="flex justify-between text-sm font-bold text-slate-900">
                        <span>Total Stay Cost</span>
                        <span class="text-[#06923E]" x-text="formatPeso(totalCost)"></span>
                    </div>
                    <div class="flex justify-between text-emerald-700 font-semibold pt-1">
                        <span>Amount Paid Now</span>
                        <span x-text="formatPeso(amountPaidNow)"></span>
                    </div>
                    <div class="flex justify-between text-slate-500">
                        <span>Remaining Balance</span>
                        <span class="font-semibold" x-text="formatPeso(balanceDue)"></span>
                    </div>
                </div>

                <div class="p-3 rounded-xl bg-amber-50 border border-amber-200 text-[11px] text-amber-900">
                    <strong>Policy Reminder:</strong> Cancellations incur a 20% fee on the paid deposit (80% refundable).
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
