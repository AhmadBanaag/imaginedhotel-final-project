@extends('layouts.hotel')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <!-- Breadcrumb & Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight">Available Rooms &amp; Suites</h1>
            <p class="text-slate-500 text-sm mt-1">Select from our 31 certified units. Filter by dates, room categories, or budget.</p>
        </div>
        <div>
            <a href="{{ route('reservations.lookup') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-indigo-600 bg-indigo-50 hover:bg-indigo-100 px-3.5 py-2 rounded-xl">
                <i class="ri-search-line"></i> Check Existing Booking
            </a>
        </div>
    </div>

    <!-- Search / Filter Card -->
    <div class="bg-white rounded-2xl p-5 shadow-xs border border-slate-200 mb-8">
        <form action="{{ route('rooms.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Check-in Date</label>
                <input type="date" name="check_in" value="{{ request('check_in', date('Y-m-d')) }}" class="w-full text-sm rounded-xl border-slate-200 focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Check-out Date</label>
                <input type="date" name="check_out" value="{{ request('check_out', date('Y-m-d', strtotime('+1 day'))) }}" class="w-full text-sm rounded-xl border-slate-200 focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Category Filter</label>
                <select name="type" class="w-full text-sm rounded-xl border-slate-200 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">All Categories</option>
                    <option value="single" {{ request('type') == 'single' ? 'selected' : '' }}>Single-bed (₱999)</option>
                    <option value="double" {{ request('type') == 'double' ? 'selected' : '' }}>Double-bed (₱1,999)</option>
                    <option value="family" {{ request('type') == 'family' ? 'selected' : '' }}>Family Room (₱2,999)</option>
                    <option value="superior" {{ request('type') == 'superior' ? 'selected' : '' }}>Superior Room (₱4,999)</option>
                </select>
            </div>
            <div class="flex items-end gap-2">
                <button type="submit" class="flex-grow bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 px-4 rounded-xl text-sm transition">
                    Apply Filters
                </button>
                <a href="{{ route('rooms.index') }}" class="p-2.5 rounded-xl border border-slate-200 text-slate-500 hover:bg-slate-50 text-sm">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Room Results Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Room 1: Single Bed -->
        <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-xs hover:shadow-md transition flex flex-col justify-between">
            <div>
                <div class="h-44 bg-slate-900 relative p-4 flex items-center justify-center text-white">
                    <div class="text-center">
                        <i class="ri-hotel-bed-line text-4xl text-amber-400"></i>
                        <span class="block text-xs font-semibold text-slate-300 mt-1">15 Units in Hotel</span>
                    </div>
                    <span class="absolute top-3 left-3 px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-500 text-white">
                        Available
                    </span>
                    <span class="absolute top-3 right-3 px-2.5 py-1 rounded-full text-xs font-bold bg-indigo-600 text-white">
                        ₱999/night
                    </span>
                </div>
                <div class="p-5">
                    <h3 class="text-lg font-bold text-slate-900">Single-bed Room</h3>
                    <p class="text-xs text-slate-500 mt-1 mb-3">Single bed, private bathroom with shower &amp; toiletries, flat screen TV, AC.</p>
                    <div class="flex flex-wrap gap-1.5 mb-4 text-[11px]">
                        <span class="px-2 py-0.5 bg-slate-100 rounded text-slate-600"><i class="ri-wifi-line"></i> Free WiFi</span>
                        <span class="px-2 py-0.5 bg-slate-100 rounded text-slate-600"><i class="ri-temp-cold-line"></i> AC</span>
                        <span class="px-2 py-0.5 bg-slate-100 rounded text-slate-600"><i class="ri-tv-line"></i> TV</span>
                    </div>
                </div>
            </div>
            <div class="p-5 pt-0">
                <a href="{{ route('reservations.create', ['room_type' => 'single']) }}" class="block w-full text-center py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold transition">
                    Reserve for ₱999 &rarr;
                </a>
            </div>
        </div>

        <!-- Room 2: Double Bed -->
        <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-xs hover:shadow-md transition flex flex-col justify-between">
            <div>
                <div class="h-44 bg-indigo-950 relative p-4 flex items-center justify-center text-white">
                    <div class="text-center">
                        <i class="ri-hotel-bed-fill text-4xl text-indigo-400"></i>
                        <span class="block text-xs font-semibold text-slate-300 mt-1">10 Units in Hotel</span>
                    </div>
                    <span class="absolute top-3 left-3 px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-500 text-white">
                        Available
                    </span>
                    <span class="absolute top-3 right-3 px-2.5 py-1 rounded-full text-xs font-bold bg-indigo-600 text-white">
                        ₱1,999/night
                    </span>
                </div>
                <div class="p-5">
                    <h3 class="text-lg font-bold text-slate-900">Double-bed Room</h3>
                    <p class="text-xs text-slate-500 mt-1 mb-3">Double bed, ample wardrobe storage, air-conditioned, shower &amp; toiletries.</p>
                    <div class="flex flex-wrap gap-1.5 mb-4 text-[11px]">
                        <span class="px-2 py-0.5 bg-slate-100 rounded text-slate-600"><i class="ri-wifi-line"></i> Free WiFi</span>
                        <span class="px-2 py-0.5 bg-slate-100 rounded text-slate-600"><i class="ri-temp-cold-line"></i> AC</span>
                        <span class="px-2 py-0.5 bg-slate-100 rounded text-slate-600"><i class="ri-tv-line"></i> TV</span>
                    </div>
                </div>
            </div>
            <div class="p-5 pt-0">
                <a href="{{ route('reservations.create', ['room_type' => 'double']) }}" class="block w-full text-center py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold transition">
                    Reserve for ₱1,999 &rarr;
                </a>
            </div>
        </div>

        <!-- Room 3: Family Room -->
        <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-xs hover:shadow-md transition flex flex-col justify-between">
            <div>
                <div class="h-44 bg-slate-900 relative p-4 flex items-center justify-center text-white">
                    <div class="text-center">
                        <i class="ri-group-line text-4xl text-emerald-400"></i>
                        <span class="block text-xs font-semibold text-slate-300 mt-1">5 Units in Hotel</span>
                    </div>
                    <span class="absolute top-3 left-3 px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-500 text-white">
                        Available
                    </span>
                    <span class="absolute top-3 right-3 px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-600 text-white">
                        ₱2,999/night
                    </span>
                </div>
                <div class="p-5">
                    <h3 class="text-lg font-bold text-slate-900">Family Room</h3>
                    <p class="text-xs text-slate-500 mt-1 mb-3">2 Double-beds, 1 Single-large bed, baby crib, shower &amp; toiletries, WiFi.</p>
                    <div class="flex flex-wrap gap-1.5 mb-4 text-[11px]">
                        <span class="px-2 py-0.5 bg-slate-100 rounded text-slate-600"><i class="ri-parent-line"></i> Crib</span>
                        <span class="px-2 py-0.5 bg-slate-100 rounded text-slate-600"><i class="ri-wifi-line"></i> WiFi</span>
                        <span class="px-2 py-0.5 bg-slate-100 rounded text-slate-600"><i class="ri-temp-cold-line"></i> AC</span>
                    </div>
                </div>
            </div>
            <div class="p-5 pt-0">
                <a href="{{ route('reservations.create', ['room_type' => 'family']) }}" class="block w-full text-center py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold transition">
                    Reserve for ₱2,999 &rarr;
                </a>
            </div>
        </div>

        <!-- Room 4: Superior Room -->
        <div class="bg-white rounded-2xl border-2 border-amber-300 overflow-hidden shadow-sm hover:shadow-md transition flex flex-col justify-between">
            <div>
                <div class="h-44 bg-amber-950 relative p-4 flex items-center justify-center text-white">
                    <div class="text-center">
                        <i class="ri-vip-crown-line text-4xl text-amber-400"></i>
                        <span class="block text-xs font-semibold text-amber-200 mt-1">1 Exclusive Suite</span>
                    </div>
                    <span class="absolute top-3 left-3 px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-400 text-slate-950">
                        VIP Exclusive
                    </span>
                    <span class="absolute top-3 right-3 px-2.5 py-1 rounded-full text-xs font-bold bg-amber-500 text-slate-950">
                        ₱4,999/night
                    </span>
                </div>
                <div class="p-5">
                    <h3 class="text-lg font-bold text-slate-900">Superior Room</h3>
                    <p class="text-xs text-slate-500 mt-1 mb-3">Massage chairs, private balcony, living room, refrigerator, washer, microwave.</p>
                    <div class="flex flex-wrap gap-1.5 mb-4 text-[11px]">
                        <span class="px-2 py-0.5 bg-amber-50 rounded text-amber-700 font-medium">Massage Chair</span>
                        <span class="px-2 py-0.5 bg-slate-100 rounded text-slate-600">Balcony</span>
                        <span class="px-2 py-0.5 bg-slate-100 rounded text-slate-600">Kitchenette</span>
                    </div>
                </div>
            </div>
            <div class="p-5 pt-0">
                <a href="{{ route('reservations.create', ['room_type' => 'superior']) }}" class="block w-full text-center py-2.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-slate-950 text-xs font-bold transition">
                    Reserve for ₱4,999 &rarr;
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
