@extends('layouts.hotel')

@section('content')
<!-- Hero Section with Booking Search Bar -->
<section class="relative bg-gradient-to-b from-slate-950 via-slate-900 to-indigo-950 text-white py-20 px-4 sm:px-6 lg:px-8 overflow-hidden">
    <!-- Ambient Background Glow -->
    <div class="absolute inset-0 opacity-20 bg-[radial-gradient(#6366f1_1px,transparent_1px)] [background-size:16px_16px]"></div>

    <div class="max-w-7xl mx-auto relative z-10 text-center">
        <!-- Eyebrow Badge -->
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-500/10 border border-indigo-400/20 text-indigo-300 text-xs font-semibold mb-6">
            <i class="ri-hotel-star-line text-amber-400"></i> Premier Hospitality in Kabacan
        </div>

        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight max-w-4xl mx-auto leading-tight">
            Experience Comfort, Elegance &amp; Seamless Room Reservations
        </h1>
        <p class="mt-4 text-base sm:text-lg text-slate-300 max-w-2xl mx-auto">
            Book certified accommodations starting at just <span class="text-amber-400 font-bold">₱999/night</span>. Choose flexible 50% Over-The-Counter deposits or fast E-Wallet QR verification.
        </p>

        <!-- Booking Search Widget Card -->
        <div class="mt-10 max-w-5xl mx-auto bg-white rounded-2xl p-4 sm:p-6 shadow-2xl text-slate-800 text-left border border-slate-100">
            <form action="{{ route('rooms.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 items-end">
                <!-- Check-in Date -->
                <div>
                    <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">
                        <i class="ri-calendar-check-line text-indigo-600 mr-1"></i> Check-in Date
                    </label>
                    <input type="date" name="check_in" value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}" class="w-full rounded-xl border-slate-200 text-sm focus:border-indigo-500 focus:ring-indigo-500 py-2.5">
                </div>

                <!-- Check-out Date -->
                <div>
                    <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">
                        <i class="ri-calendar-event-line text-indigo-600 mr-1"></i> Check-out Date
                    </label>
                    <input type="date" name="check_out" value="{{ date('Y-m-d', strtotime('+1 day')) }}" min="{{ date('Y-m-d', strtotime('+1 day')) }}" class="w-full rounded-xl border-slate-200 text-sm focus:border-indigo-500 focus:ring-indigo-500 py-2.5">
                </div>

                <!-- Room Type -->
                <div>
                    <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">
                        <i class="ri-hotel-bed-line text-indigo-600 mr-1"></i> Room Category
                    </label>
                    <select name="type" class="w-full rounded-xl border-slate-200 text-sm focus:border-indigo-500 focus:ring-indigo-500 py-2.5">
                        <option value="">All Categories (31 Rooms)</option>
                        <option value="single">Single-bed Room (₱999)</option>
                        <option value="double">Double-bed Room (₱1,999)</option>
                        <option value="family">Family Room (₱2,999)</option>
                        <option value="superior">Superior Room (₱4,999)</option>
                    </select>
                </div>

                <!-- Budget Range -->
                <div>
                    <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">
                        <i class="ri-money-dollar-circle-line text-indigo-600 mr-1"></i> Max Budget
                    </label>
                    <select name="budget" class="w-full rounded-xl border-slate-200 text-sm focus:border-indigo-500 focus:ring-indigo-500 py-2.5">
                        <option value="">Any Budget</option>
                        <option value="1000">Up to ₱1,000</option>
                        <option value="2000">Up to ₱2,000</option>
                        <option value="3000">Up to ₱3,000</option>
                        <option value="5000">Up to ₱5,000</option>
                    </select>
                </div>

                <!-- Submit Search Button -->
                <div>
                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-4 rounded-xl text-sm transition shadow-md flex items-center justify-center gap-2">
                        <i class="ri-search-2-line"></i> Search Available
                    </button>
                </div>
            </form>
        </div>

        <!-- Trust Badges -->
        <div class="mt-8 flex flex-wrap justify-center gap-6 text-xs text-slate-400">
            <span class="inline-flex items-center gap-1.5"><i class="ri-shield-check-line text-emerald-400 text-sm"></i> Real-time Room Availability</span>
            <span class="inline-flex items-center gap-1.5"><i class="ri-bank-card-line text-blue-400 text-sm"></i> 50% OTC Deposit or E-Wallet QR</span>
            <span class="inline-flex items-center gap-1.5"><i class="ri-refund-line text-amber-400 text-sm"></i> Fair Cancellation (80% Refund Policy)</span>
        </div>
    </div>
</section>

<!-- Room Categories Showcase Section -->
<section class="py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center max-w-3xl mx-auto mb-12">
        <h2 class="text-xs font-bold uppercase tracking-wider text-indigo-600 mb-1">Our Accommodations</h2>
        <h3 class="text-3xl font-extrabold text-slate-900 tracking-tight">Handcrafted Suites For Every Travel Need</h3>
        <p class="mt-2 text-slate-600 text-sm">
            Total of 31 rooms meticulously managed to guarantee clean, safe, and comfortable stays.
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- 1. Single-bed Room -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex flex-col hover:shadow-lg transition">
            <div class="h-44 bg-slate-800 relative flex items-center justify-center text-white p-4">
                <div class="text-center">
                    <i class="ri-hotel-bed-line text-4xl text-amber-400 mb-1"></i>
                    <span class="block text-xs uppercase tracking-widest text-slate-300">15 Units Available</span>
                </div>
                <span class="absolute top-3 right-3 px-2.5 py-1 rounded-full text-xs font-bold bg-indigo-600 text-white">
                    ₱999<span class="text-[10px] font-normal">/night</span>
                </span>
            </div>
            <div class="p-5 flex-grow flex flex-col justify-between">
                <div>
                    <h4 class="text-lg font-bold text-slate-900">Single-bed Room</h4>
                    <p class="text-xs text-slate-500 mt-1 mb-4">
                        Ideal for solo business travellers and students seeking quiet comfort.
                    </p>
                    <ul class="text-xs space-y-1.5 text-slate-600 mb-4">
                        <li><i class="ri-check-line text-emerald-600 mr-1.5"></i> Single Bed &amp; Wardrobe Storage</li>
                        <li><i class="ri-check-line text-emerald-600 mr-1.5"></i> Air-conditioned &amp; Free WiFi</li>
                        <li><i class="ri-check-line text-emerald-600 mr-1.5"></i> Flat Screen TV</li>
                        <li><i class="ri-check-line text-emerald-600 mr-1.5"></i> Private Shower &amp; Toiletries</li>
                    </ul>
                </div>
                <a href="{{ route('reservations.create', ['room_type' => 'single']) }}" class="w-full text-center py-2.5 px-4 rounded-xl bg-slate-900 hover:bg-indigo-600 text-white text-xs font-semibold transition">
                    Book for ₱999 &rarr;
                </a>
            </div>
        </div>

        <!-- 2. Double-bed Room -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex flex-col hover:shadow-lg transition">
            <div class="h-44 bg-indigo-950 relative flex items-center justify-center text-white p-4">
                <div class="text-center">
                    <i class="ri-hotel-bed-fill text-4xl text-indigo-400 mb-1"></i>
                    <span class="block text-xs uppercase tracking-widest text-slate-300">10 Units Available</span>
                </div>
                <span class="absolute top-3 right-3 px-2.5 py-1 rounded-full text-xs font-bold bg-indigo-600 text-white">
                    ₱1,999<span class="text-[10px] font-normal">/night</span>
                </span>
            </div>
            <div class="p-5 flex-grow flex flex-col justify-between">
                <div>
                    <h4 class="text-lg font-bold text-slate-900">Double-bed Room</h4>
                    <p class="text-xs text-slate-500 mt-1 mb-4">
                        Spacious layout perfect for couples or pairs visiting USM Kabacan.
                    </p>
                    <ul class="text-xs space-y-1.5 text-slate-600 mb-4">
                        <li><i class="ri-check-line text-emerald-600 mr-1.5"></i> Double Bed &amp; Ample Storage</li>
                        <li><i class="ri-check-line text-emerald-600 mr-1.5"></i> Air-conditioned &amp; Free High-speed WiFi</li>
                        <li><i class="ri-check-line text-emerald-600 mr-1.5"></i> Flat Screen TV</li>
                        <li><i class="ri-check-line text-emerald-600 mr-1.5"></i> Bathroom with Shower &amp; Toiletries</li>
                    </ul>
                </div>
                <a href="{{ route('reservations.create', ['room_type' => 'double']) }}" class="w-full text-center py-2.5 px-4 rounded-xl bg-slate-900 hover:bg-indigo-600 text-white text-xs font-semibold transition">
                    Book for ₱1,999 &rarr;
                </a>
            </div>
        </div>

        <!-- 3. Family Room -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex flex-col hover:shadow-lg transition">
            <div class="h-44 bg-slate-900 relative flex items-center justify-center text-white p-4">
                <div class="text-center">
                    <i class="ri-group-line text-4xl text-emerald-400 mb-1"></i>
                    <span class="block text-xs uppercase tracking-widest text-slate-300">5 Units Available</span>
                </div>
                <span class="absolute top-3 right-3 px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-600 text-white">
                    ₱2,999<span class="text-[10px] font-normal">/night</span>
                </span>
            </div>
            <div class="p-5 flex-grow flex flex-col justify-between">
                <div>
                    <h4 class="text-lg font-bold text-slate-900">Family Room</h4>
                    <p class="text-xs text-slate-500 mt-1 mb-4">
                        Family-friendly suite accommodating groups with infants and kids.
                    </p>
                    <ul class="text-xs space-y-1.5 text-slate-600 mb-4">
                        <li><i class="ri-check-line text-emerald-600 mr-1.5"></i> 2 Double-beds + 1 Single-large bed</li>
                        <li><i class="ri-check-line text-emerald-600 mr-1.5"></i> Baby Crib Included</li>
                        <li><i class="ri-check-line text-emerald-600 mr-1.5"></i> Air-conditioned &amp; Free WiFi</li>
                        <li><i class="ri-check-line text-emerald-600 mr-1.5"></i> Private Bathroom with Shower &amp; Toiletries</li>
                    </ul>
                </div>
                <a href="{{ route('reservations.create', ['room_type' => 'family']) }}" class="w-full text-center py-2.5 px-4 rounded-xl bg-slate-900 hover:bg-indigo-600 text-white text-xs font-semibold transition">
                    Book for ₱2,999 &rarr;
                </a>
            </div>
        </div>

        <!-- 4. Superior Suite -->
        <div class="bg-white rounded-2xl border-2 border-amber-300 shadow-md overflow-hidden flex flex-col hover:shadow-xl transition relative">
            <div class="h-44 bg-gradient-to-tr from-amber-900 to-slate-900 relative flex items-center justify-center text-white p-4">
                <span class="absolute top-3 left-3 px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-400 text-slate-950 uppercase tracking-wider">
                    VIP Flagship Suite
                </span>
                <div class="text-center">
                    <i class="ri-vip-crown-line text-4xl text-amber-400 mb-1"></i>
                    <span class="block text-xs uppercase tracking-widest text-slate-300">1 Unit Exclusive</span>
                </div>
                <span class="absolute top-3 right-3 px-2.5 py-1 rounded-full text-xs font-bold bg-amber-500 text-slate-950">
                    ₱4,999<span class="text-[10px] font-normal">/night</span>
                </span>
            </div>
            <div class="p-5 flex-grow flex flex-col justify-between">
                <div>
                    <h4 class="text-lg font-bold text-slate-900">Superior Room</h4>
                    <p class="text-xs text-slate-500 mt-1 mb-4">
                        The ultimate luxury suite equipped with private living room, balcony and appliances.
                    </p>
                    <ul class="text-xs space-y-1.5 text-slate-600 mb-4">
                        <li><i class="ri-check-line text-amber-600 mr-1.5"></i> 2 Double-beds + 1 Double-large Bed</li>
                        <li><i class="ri-check-line text-amber-600 mr-1.5"></i> Massage Chairs &amp; Living Room</li>
                        <li><i class="ri-check-line text-amber-600 mr-1.5"></i> Scenic Balcony &amp; Room Dividers</li>
                        <li><i class="ri-check-line text-amber-600 mr-1.5"></i> Refrigerator, Microwave &amp; Washer</li>
                    </ul>
                </div>
                <a href="{{ route('reservations.create', ['room_type' => 'superior']) }}" class="w-full text-center py-2.5 px-4 rounded-xl bg-amber-500 hover:bg-amber-600 text-slate-950 text-xs font-bold transition">
                    Reserve Superior (₱4,999) &rarr;
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Amenities & Service Features Section -->
<section class="py-16 bg-white border-y border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <h3 class="text-2xl font-bold text-slate-900 tracking-tight">Hotel Amenities &amp; Services</h3>
            <p class="text-slate-500 text-sm mt-1">Everything you need for a restful, convenient stay in Kabacan.</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <div class="p-5 rounded-2xl bg-slate-50 border border-slate-100 flex items-start gap-4">
                <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center text-xl shrink-0">
                    <i class="ri-wifi-line"></i>
                </div>
                <div>
                    <h5 class="text-sm font-semibold text-slate-900">High-Speed WiFi</h5>
                    <p class="text-xs text-slate-500 mt-0.5">Complimentary fast internet across all rooms.</p>
                </div>
            </div>

            <div class="p-5 rounded-2xl bg-slate-50 border border-slate-100 flex items-start gap-4">
                <div class="w-10 h-10 rounded-xl bg-teal-100 text-teal-600 flex items-center justify-center text-xl shrink-0">
                    <i class="ri-temp-cold-line"></i>
                </div>
                <div>
                    <h5 class="text-sm font-semibold text-slate-900">Full Air-Conditioning</h5>
                    <p class="text-xs text-slate-500 mt-0.5">Adjustable climate control in every room.</p>
                </div>
            </div>

            <div class="p-5 rounded-2xl bg-slate-50 border border-slate-100 flex items-start gap-4">
                <div class="w-10 h-10 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center text-xl shrink-0">
                    <i class="ri-tv-line"></i>
                </div>
                <div>
                    <h5 class="text-sm font-semibold text-slate-900">Flat Screen TV</h5>
                    <p class="text-xs text-slate-500 mt-0.5">High definition entertainment screens.</p>
                </div>
            </div>

            <div class="p-5 rounded-2xl bg-slate-50 border border-slate-100 flex items-start gap-4">
                <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center text-xl shrink-0">
                    <i class="ri-wallet-3-line"></i>
                </div>
                <div>
                    <h5 class="text-sm font-semibold text-slate-900">Flexible 50% OTC</h5>
                    <p class="text-xs text-slate-500 mt-0.5">Pay 50% deposit now, 50% balance at check-in.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Reservation Workflow Guidance Banner -->
<section class="py-14 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-indigo-900 text-white rounded-3xl p-8 sm:p-12 relative overflow-hidden shadow-xl">
        <div class="relative z-10 max-w-2xl">
            <span class="text-xs uppercase font-bold tracking-widest text-indigo-300">Fast &amp; Verified</span>
            <h3 class="text-2xl sm:text-3xl font-extrabold mt-2 tracking-tight">Need to Check or Modify an Existing Booking?</h3>
            <p class="text-indigo-200 text-sm mt-3 leading-relaxed">
                Enter your unique Reservation Code and Email into our fast lookup tool to retrieve your printable E-receipt, check stay status, or process cancellations.
            </p>
            <div class="mt-6 flex flex-wrap gap-4">
                <a href="{{ route('reservations.lookup') }}" class="px-5 py-3 rounded-xl bg-amber-400 hover:bg-amber-500 text-slate-950 font-bold text-sm shadow transition">
                    Look Up Booking Code
                </a>
                <a href="{{ route('rooms.index') }}" class="px-5 py-3 rounded-xl bg-indigo-800 hover:bg-indigo-700 text-white font-semibold text-sm transition border border-indigo-700">
                    Browse Room Catalog
                </a>
            </div>
        </div>
        <div class="absolute -right-10 -bottom-10 opacity-10 text-white text-[16rem]">
            <i class="ri-hotel-bed-line"></i>
        </div>
    </div>
</section>
@endsection
