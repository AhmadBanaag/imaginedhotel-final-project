@extends('layouts.hotel')

@section('reservation-create')
@include('components.navbar2')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-25 pb-15" x-data="{
    roomType: '{{ request('room_type', 'single') }}',
    checkIn: '{{ date('Y-m-d') }}',
    checkOut: '{{ date('Y-m-d', strtotime('+1 day')) }}',
    paymentMethod: 'otc',
    rates: {
        'single': 999,
        'double': 1999,
        'family': 2999,
        'superior': 4999
    },
    get price() {
        return this.rates[this.roomType] || 999;
    },
    get otcDeposit() {
        return Math.round(this.price * 0.5);
    },
    get otcRemaining() {
        return this.price - this.otcDeposit;
    }
}">
    <!-- Header -->
    <div class="mb-8">
        <a href="{{ route('rooms.index') }}" class="text-xs font-semibold text-[#EDC92C] hover:underline inline-flex items-center gap-1 mb-2">
            &larr; Back to Rooms
        </a>
        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight mb-2">Complete Reservation!</h1>
        <p class="text-base text-slate-500 tracking-tight">Just fill in the (*) required info, and you're all set!</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-5">
        <!-- Form Column (8 cols) -->
            
            <form action="{{ route('reservations.confirmation') }}" method="GET">
                <!-- Step 1: Guest Information -->
                <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-2xs mb-3">
                    <div class="flex items-center gap-2 mb-4 pb-3 border-b border-slate-100">
                        <span class="w-6 h-6 rounded-full bg-[#EDC92C] text-white font-bold text-xs flex items-center justify-center">1</span>
                        <h3 class="text-lg font-bold text-slate-900">Guest Information</h3>
                        <span class="text-xs text-slate-400 ml-auto">*Fill up all (*) required details</span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">First Name</label>
                            <input type="text" name="first_name" required value="{{ Auth::check() ? explode(' ', Auth::user()->name)[0] : 'Juan' }}" class="w-full text-sm rounded-xl border-slate-200 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Last Name</label>
                            <input type="text" name="last_name" required value="{{ Auth::check() ? (explode(' ', Auth::user()->name)[1] ?? 'Dela Cruz') : 'Dela Cruz' }}" class="w-full text-sm rounded-xl border-slate-200 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Email Address (For E-Receipt)</label>
                            <input type="email" name="email" required value="{{ Auth::check() ? Auth::user()->email : 'guest@example.com' }}" class="w-full text-sm rounded-xl border-slate-200 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Phone Number</label>
                            <input type="tel" name="phone_number" required value="09171234567" placeholder="e.g. 09171234567" class="w-full text-sm rounded-xl border-slate-200 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                    </div>
                </div>

                <!-- Step 2: Stay Dates & Room Selection -->
                <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-2xs mb-3">
                    <div class="flex items-center gap-2 mb-4 pb-3 border-b border-slate-100">
                        <span class="w-6 h-6 rounded-full bg-[#EDC92C] text-white font-bold text-xs flex items-center justify-center">2</span>
                        <h3 class="text-lg font-bold text-slate-900">Stay dates</h3>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Check-in Date</label>
                            <input type="date" name="check_in" x-model="checkIn" class="w-full text-sm rounded-xl border-slate-200 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Check-out Date</label>
                            <input type="date" name="check_out" x-model="checkOut" class="w-full text-sm rounded-xl border-slate-200 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                    </div>
                </div>

                <!-- Step 3: Payment Method Selection -->
                <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-2xs mb-3">
                    <div class="flex items-center gap-2 mb-4 pb-3 border-b border-slate-100">
                        <span class="w-6 h-6 rounded-full bg-[#EDC92C] text-white font-bold text-xs flex items-center justify-center">3</span>
                        <h3 class="text-lg font-bold text-slate-900">Payment Option</h3>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                        <!-- OTC Option -->
                        <label :class="paymentMethod === 'otc' ? 'border-[#EDC92C] bg-[#EDC92C]/50' : 'border-slate-200'" class="p-4 rounded-xl border-2 cursor-pointer flex items-start gap-3 transition">
                            <input type="radio" name="payment_method" value="otc" x-model="paymentMethod" class="mt-1 text-[#EDC92C] focus:ring-[#EDC92C]">
                            <div>
                                <span class="block text-sm font-bold text-black">Over The Counter (OTC)</span>
                                <span class="block text-xs text-[#06923E] font-semibold mt-0.5">Pay 50% downpayment (₱<span x-text="otcDeposit"></span>)</span>
                                <p class="text-xs text-slate-500 mt-1">Remaining 50% balance (₱<span x-text="otcRemaining"></span>) paid directly to the receptionist upon check-in.</p>
                            </div>
                        </label>

                        <!-- E-Wallet Option -->
                        <label :class="paymentMethod === 'ewallet' ? 'border-[#EDC92C] bg-[#EDC92C]/50' : 'border-slate-200'" class="p-4 rounded-xl border-2 cursor-pointer flex items-start gap-3 transition">
                            <input type="radio" name="payment_method" value="ewallet" x-model="paymentMethod" class="mt-1 text-[#EDC92C] focus:ring-[#EDC92C]">
                            <div>
                                <span class="block text-sm font-bold text-black">E-Wallet (GCash / Maya QR)</span>
                                <span class="block text-xs text-[#06923E] font-semibold mt-0.5">Scan QR &amp; instant verification</span>
                                <p class="text-xs text-slate-500 mt-1">Pay full amount (₱<span x-text="price"></span>) or deposit via online wallet QR.</p>
                            </div>
                        </label>
                    </div>

                    <!-- E-Wallet QR Display Section -->
                    <div x-show="paymentMethod === 'ewallet'" class="p-4 rounded-xl bg-slate-50 border border-slate-200 flex flex-col sm:flex-row items-center gap-6">
                        <div class="w-36 h-36 bg-white p-2 rounded-xl border border-slate-200 flex flex-col items-center justify-center shrink-0 shadow-2xs">
                            <img 
                                src="{{ asset('images/imagined-hotel-qr.jpg')}}"
                                alt="ImaginedHotel QR"
                                class="w-full h-full object-contain"
                            />
                        </div>
                        <div class="space-y-2">
                            <h4 class="text-sm font-bold text-slate-900">Scan QR via GCash or Maya App</h4>
                            <p class="text-xs text-slate-500">Account Name: <strong>ImaginedHotel</strong></p>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Enter Payment Reference Number</label>
                                <input type="text" name="ref_number" placeholder="e.g. 10023491823" class="w-full text-sm rounded-xl border-slate-200 focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Terms & Cancellation Policy Notice -->
                <div class="p-4 rounded-xl bg-amber-50 border border-amber-200 text-amber-900 text-xs mb-6 flex items-start gap-3">
                    <i class="ri-alert-line text-amber-600 text-lg shrink-0 mt-0.5"></i>
                    <div>
                        <strong class="font-semibold block mb-0.5">Hotel Cancellation Policy Notice:</strong>
                        If you choose to cancel this reservation later, <strong>20% of the paid deposit will be deducted</strong> as an administrative processing fee, returning 80% to you.
                    </div>
                </div>
            </form>
        </div>

        <!-- Sticky Booking Summary Sidebar (4 cols) -->
        <div class="lg:col-span-4">
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-2xs top-24 sticky">
                <h3 class="text-base font-bold text-slate-900 pb-3 border-b border-slate-100 mb-4">Reservation Summary</h3>

                <div class="space-y-3 text-xs">
                    <div class="flex justify-between">
                        <span class="text-slate-500">Selected Room</span>
                        <span class="font-semibold text-slate-900 uppercase" x-text="roomType + ' Room'"></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Nightly Rate</span>
                        <span class="font-semibold text-slate-900">₱<span x-text="price"></span></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Duration</span>
                        <span class="font-semibold text-slate-900">1 Night</span>
                    </div>

                    <div x-show="paymentMethod === 'otc'" class="space-y-1.5">
                        <div class="flex justify-between text-xs text-emerald-700 font-semibold">
                            <span>50% Downpayment Today</span>
                            <span>₱<span x-text="otcDeposit"></span></span>
                        </div>
                        <div class="flex justify-between text-xs text-slate-500">
                            <span>Balance Due at Check-in</span>
                            <span>₱<span x-text="otcRemaining"></span></span>
                        </div>
                    </div>

                    <hr class="border-slate-100 my-2">
                    <div class="flex justify-between text-sm font-bold text-slate-900">
                        <span>Total Stay Cost</span>
                        <span class="text-[#EDC92C] font-bold">₱<span x-text="price"></span></span>
                    </div>

                <div class="flex gap-3 w-full pt-4">

                    <button type="submit" class="flex-1 h-10 rounded-xl bg-[#EDC92C] hover:bg-[#06923E] text-white font-bold text-base shadow-md transition flex items-center justify-center gap-2">
                        <i class="text-xs"></i> Pay as Guest
                    </button>

                    <button type="submit" class="flex-1 h-10 rounded-xl bg-[#EDC92C] hover:bg-[#06923E] text-white font-bold text-base shadow-md transition flex items-center justify-center gap-2">
                        <i class="text-xs"></i> Login
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
