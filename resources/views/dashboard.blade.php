@extends('layouts.hotel')

@section('main-section')
    @include('components.navbar')

    <!-- Dashboard Hero Header -->
    <section class="relative bg-[url('../assets/images/hero/dashboard-header.webp')] bg-cover bg-center text-white py-24 sm:py-32 px-4 sm:px-6 lg:px-8">
        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/85 via-slate-900/50 to-slate-900/70"></div>

        <div class="max-w-7xl mx-auto relative z-10 text-center">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-[#EDC92C] text-slate-900 mb-4 shadow-sm">
                <i class="ri-user-star-line"></i> Member Hub
            </span>
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-white drop-shadow-md">
                My Account Dashboard
            </h1>
            <p class="mt-3 text-sm sm:text-base text-slate-200 max-w-2xl mx-auto">
                Explore real-time room availability, manage your account profile, and plan your stay in Kabacan.
            </p>
        </div>
    </section>

    <!-- Main Content Container -->
    <div class="py-10 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            <!-- User Management Showcase: Member Profile & Hotel Status Banner -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div class="space-y-2">
                    <div class="flex flex-wrap items-center gap-2">
                        <h2 class="text-2xl sm:text-3xl font-bold text-slate-900">
                            Welcome back, {{ Auth::user()->name }}!
                        </h2>
                    </div>
                    
                    <div class="flex flex-wrap items-center gap-x-4 gap-y-1 text-sm text-slate-500">
                        <span><i class="ri-mail-line text-slate-400 mr-1"></i> {{ Auth::user()->email }}</span>
                        @if(Auth::user()->phone)
                            <span><i class="ri-phone-line text-slate-400 mr-1"></i> {{ Auth::user()->phone }}</span>
                        @endif
                        <span class="text-emerald-600 font-medium">
                            <i class="ri-hotel-bed-line mr-1"></i> {{ $totalAvailableRooms ?? 0 }} rooms ready for check-in today
                        </span>
                    </div>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                   
                    <a href="#rooms-section" class="inline-flex items-center px-4 py-2.5 text-sm font-semibold rounded-xl text-white bg-[#06923E] hover:bg-[#057a34] shadow-sm transition">
                        <i class="ri-search-line mr-1.5"></i> Browse Rooms
                    </a>
                </div>
            </div>

            <!-- Showcase of Imagined Hotel Rooms -->


            <!-- Room Management Showcase: Dynamic Room Inventory Catalog -->
            <div id="rooms-section" class="space-y-6 pt-4">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h3 class="text-2xl font-bold text-slate-900">Available Rooms & Suites</h3>
                        <p class="text-slate-500 text-sm mt-1">
                            Availability and Pricing of rooms.
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @forelse($roomTypes as $type)
                        @php
                           
                            $slug = \Illuminate\Support\Str::slug($type->name);

                            $roomImages = [
                                'single-bed-room' => 'single-bed-room.jpg',
                                'double-bed-room' => 'double-bed-room.jpg',
                                'family-room'     => 'family-room.jpg',
                                'suite'           => 'deluxe-room-1.webp', //ai nlang kay sige  wa pa picture
                            ];

                            $imageName = $roomImages[$slug] ?? 'single-bed-room.jpg';


                        @endphp

                        <div class="bg-white rounded-2xl border border-slate-200 shadow-xs hover:shadow-xl transition-all duration-300 hover:-translate-y-1 flex flex-col justify-between overflow-hidden group">
                            
                            <!-- 1. Image Header with Floating Price Badge -->
                            <div class="h-48 bg-slate-200 relative overflow-hidden">
                                <img src="{{ Vite::asset('resources/assets/images/rooms/' . $imageName) }}" 
                                     alt="{{ $type->name }}" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                
                                <!-- Price Badge (Top Right) -->
                                <span class="absolute top-3 right-3 px-2.5 py-1 rounded-full text-xs font-bold bg-[#06923E] text-white shadow-sm">
                                    ₱{{ number_format($type->PricePerNight, 2) }}<span class="text-[10px] font-normal">/night</span>
                                </span>
                            </div>

                            <!-- 2. Room Details -->
                            <div class="p-5 flex-1 flex flex-col">
                                <div class="flex items-center justify-between gap-2 mb-2">
                                    <h4 class="text-lg font-bold text-slate-900 group-hover:text-emerald-700 transition-colors">
                                        {{ $type->name }}
                                    </h4>

                                    @if(($type->available_rooms_count ?? 0) > 0)
                                        <span class="shrink-0 text-[11px] font-semibold px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            {{ $type->available_rooms_count }} Vacant
                                        </span>
                                    @else
                                        <span class="shrink-0 text-[11px] font-semibold px-2 py-0.5 rounded-full bg-rose-50 text-rose-700 border border-rose-200">
                                            Fully Booked
                                        </span>
                                    @endif
                                </div>

                                <p class="text-xs text-slate-500 mt-1 flex items-center gap-1.5">
                                    <i class="ri-user-line text-slate-400"></i> Max Guests: {{ $type->maxGuest }}
                                </p>
                            </div>

                            <!-- 3. Card Footer & Action Button -->
                            <div class="p-4 bg-slate-50/75 border-t border-slate-100 flex items-center justify-between">
                                <span class="text-xs text-slate-400">
                                    ID #{{ $type->room_type_id }}
                                </span>
                                @if(($type->available_rooms_count ?? 0) > 0)
                                    <a href="{{ route('reservations.create') }}" class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-[#EDC92C] hover:bg-[#e0bc24] text-slate-900 transition">
                                        Reserve Room
                                    </a>
                                @else
                                    <button disabled class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-slate-200 text-slate-400 cursor-not-allowed">
                                        Unavailable
                                    </button>
                                @endif
                            </div>

                        </div>
                    @empty
                        <div class="col-span-full bg-white p-8 rounded-2xl border border-slate-200 text-center text-slate-500">
                            <i class="ri-hotel-line text-4xl text-slate-300 mb-2"></i>
                            <p>No room categories found in the database. Please seed or add room types.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
