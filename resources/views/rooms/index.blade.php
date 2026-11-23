@extends('layouts.hotel')

@section('rooms')
@include('components.navbar2')
<section class="pt-18">
    @include('components.search-widget') 
</section>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-9 pb-3">
    <!-- Search / Filter Card -->
    <section class="pb-10 pt-1 max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
        <!-- Breadcrumb & Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight">Available Rooms</h1>
                <p class="text-slate-500 text-sm mt-1">Select from our best rooms in ImaginedHotel.</p>
            </div>
        </div>

        <!-- Room Results Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Room 1: Single Bed -->
            <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-2xs hover:shadow-md transition flex flex-col justify-between">
                <div>
                    <div class="h-44 bg-[url('../assets/images/rooms/single-bed-room.jpg')] bg-cover bg-center relative p-4 flex items-center justify-center text-white">>
                        <span class="absolute top-3 left-3 px-2 py-0.5 rounded-full text-[10px] font-bold bg-[#06923E] text-white">
                            Available
                        </span>
                        <span class="absolute top-3 right-3 px-2.5 py-1 rounded-full text-xs font-bold bg-[#06923E] text-white">
                            ₱999<span class="text-[10px] font-normal">/night</span>
                        </span>
                    </div>
                    <div class="p-5">
                        <h3 class="text-lg font-bold text-slate-900">Single-bed Room</h3>
                        <p class="text-xs text-slate-500 mt-1 mb-3">Single bed, private bathroom with shower &amp; toiletries, flat screen TV, AC.</p>
                        <div class="flex flex-wrap gap-1.5 mb-4 text-[11px]">
                            <span class="px-2 py-0.5 bg-slate-100 rounded-sm text-slate-600"><i class="ri-wifi-line"></i> Free WiFi</span>
                            <span class="px-2 py-0.5 bg-slate-100 rounded-sm text-slate-600"><i class="ri-temp-cold-line"></i> AC</span>
                            <span class="px-2 py-0.5 bg-slate-100 rounded-sm text-slate-600"><i class="ri-tv-line"></i> TV</span>
                        </div>
                    </div>
                </div>
                <div class="p-5 pt-0">
                    <a href="{{ route('reservations.create', ['room_type' => 'single']) }}" class="block w-full text-center py-2.5 rounded-xl bg-[#06923E] hover:bg-[#EDC92C] text-white text-xs font-semibold transition">
                        Reserve for ₱999 &rarr;
                    </a>
                </div>
            </div>

            <!-- Room 2: Double Bed -->
            <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-2xs hover:shadow-md transition flex flex-col justify-between">
                <div>
                    <div class="h-44 bg-[url('../assets/images/rooms/double-bed-room.jpg')] bg-cover bg-center relative p-4 flex items-center justify-center text-white">
                        <span class="absolute top-3 left-3 px-2 py-0.5 rounded-full text-[10px] font-bold bg-[#06923E] text-white">
                            Available
                        </span>
                        <span class="absolute top-3 right-3 px-2.5 py-1 rounded-full text-xs font-bold bg-[#06923E] text-white">
                            ₱1,999<span class="text-[10px] font-normal">/night</span>
                        </span>
                    </div>
                    <div class="p-5">
                        <h3 class="text-lg font-bold text-slate-900">Double-bed Room</h3>
                        <p class="text-xs text-slate-500 mt-1 mb-3">Double bed, ample wardrobe storage, air-conditioned, shower &amp; toiletries.</p>
                        <div class="flex flex-wrap gap-1.5 mb-4 text-[11px]">
                            <span class="px-2 py-0.5 bg-slate-100 rounded-sm text-slate-600"><i class="ri-wifi-line"></i> Free WiFi</span>
                            <span class="px-2 py-0.5 bg-slate-100 rounded-sm text-slate-600"><i class="ri-temp-cold-line"></i> AC</span>
                            <span class="px-2 py-0.5 bg-slate-100 rounded-sm text-slate-600"><i class="ri-tv-line"></i> TV</span>
                        </div>
                    </div>
                </div>
                <div class="p-5 pt-0">
                    <a href="{{ route('reservations.create', ['room_type' => 'double']) }}" class="block w-full text-center py-2.5 rounded-xl bg-[#06923E] hover:bg-[#EDC92C] text-white text-xs font-semibold transition">
                        Reserve for ₱1,999 &rarr;
                    </a>
                </div>
            </div>

            <!-- Room 3: Family Room -->
            <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-2xs hover:shadow-md transition flex flex-col justify-between">
                <div>
                    <div class="h-44 bg-[url('../assets/images/rooms/family-room.jpg')] bg-cover bg-center relative p-4 flex items-center justify-center text-white">
                        <span class="absolute top-3 left-3 px-2 py-0.5 rounded-full text-[10px] font-bold bg-[#06923E] text-white">
                            Available
                        </span>
                        <span class="absolute top-3 right-3 px-2.5 py-1 rounded-full text-xs font-bold bg-[#06923E] text-white">
                            ₱2,999<span class="text-[10px] font-normal">/night</span>
                        </span>
                    </div>
                    <div class="p-5">
                        <h3 class="text-lg font-bold text-slate-900">Family Room</h3>
                        <p class="text-xs text-slate-500 mt-1 mb-3">2 Double-beds, 1 Single-large bed, baby crib, shower &amp; toiletries, WiFi.</p>
                        <div class="flex flex-wrap gap-1.5 mb-4 text-[11px]">
                            <span class="px-2 py-0.5 bg-slate-100 rounded-sm text-slate-600"><i class="ri-parent-line"></i> Crib</span>
                            <span class="px-2 py-0.5 bg-slate-100 rounded-sm text-slate-600"><i class="ri-wifi-line"></i> WiFi</span>
                            <span class="px-2 py-0.5 bg-slate-100 rounded-sm text-slate-600"><i class="ri-temp-cold-line"></i> AC</span>
                        </div>
                    </div>
                </div>
                <div class="p-5 pt-0">
                    <a href="{{ route('reservations.create', ['room_type' => 'family']) }}" class="block w-full text-center py-2.5 rounded-xl bg-[#06923E] hover:bg-[#EDC92C] text-white text-xs font-semibold transition">
                        Reserve for ₱2,999 &rarr;
                    </a>
                </div>
            </div>

            <!-- Room 4: Superior Room -->
            <div class="bg-white rounded-2xl border-2 border-amber-300 overflow-hidden shadow-xs hover:shadow-md transition flex flex-col justify-between">
                <div>
                    <div class="h-44 bg-[url('../assets/images/rooms/deluxe-room-1.webp')] bg-cover bg-center relative p-4 flex items-center justify-center text-white">
                        <span class="absolute top-3 left-3 px-2 py-0.5 rounded-full text-[10px] font-bold bg-[#06923E] text-white">
                            Available
                        </span>
                        <span class="absolute top-3 right-3 px-2.5 py-1 rounded-full text-xs font-bold bg-[#EDC92C] text-white">
                            ₱4,999<span class="text-[10px] font-normal">/night</span>
                        </span>
                    </div>
                    <div class="p-5">
                        <h3 class="text-lg font-bold text-slate-900">Superior Room</h3>
                        <p class="text-xs text-slate-500 mt-1 mb-3">Massage chairs, private balcony, living room, refrigerator, washer, microwave.</p>
                        <div class="flex flex-wrap gap-1.5 mb-4 text-[11px]">
                            <span class="px-2 py-0.5 bg-amber-50 rounded-sm text-amber-700 font-medium">Massage Chair</span>
                            <span class="px-2 py-0.5 bg-slate-100 rounded-sm text-slate-600">Balcony</span>
                            <span class="px-2 py-0.5 bg-slate-100 rounded-sm text-slate-600">Kitchenette</span>
                        </div>
                    </div>
                </div>
                <div class="p-5 pt-0">
                    <a href="{{ route('reservations.create', ['room_type' => 'superior']) }}" class="block w-full text-center py-2.5 rounded-xl bg-[#EDC92C] hover:bg-amber-600 text-white text-xs font-bold transition">
                        Reserve for ₱4,999 &rarr;
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
