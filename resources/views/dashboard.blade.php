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
                        @if(Auth::user()->is_active ?? true)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span> Active Account
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-rose-100 text-rose-800">
                                <span class="w-1.5 h-1.5 rounded-full bg-rose-500 mr-1.5"></span> Deactivated
                            </span>
                        @endif
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
                    <a href="{{ route('profile.edit') }}" class="inline-flex items-center px-4 py-2.5 text-sm font-medium rounded-xl text-slate-700 bg-slate-100 hover:bg-slate-200 transition">
                        <i class="ri-settings-4-line mr-1.5"></i> Edit Profile
                    </a>
                    <a href="#rooms-section" class="inline-flex items-center px-4 py-2.5 text-sm font-semibold rounded-xl text-white bg-[#06923E] hover:bg-[#057a34] shadow-sm transition">
                        <i class="ri-search-line mr-1.5"></i> Browse Rooms
                    </a>
                </div>
            </div>

            <!-- Quick Action Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- 1. Reservations Card -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition flex flex-col justify-between group">
                    <div>
                        <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition-transform">
                            <i class="ri-calendar-check-line"></i>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900">My Reservations</h3>
                        <p class="text-slate-500 text-sm mt-1 leading-relaxed">
                            View your current and previous booking schedules, confirmed stays, and printable E-receipts.
                        </p>
                    </div>
                    <div class="mt-5 pt-4 border-t border-slate-100">
                        <a href="{{ route('guest.reservations.index') }}" class="text-indigo-600 text-sm font-semibold hover:text-indigo-800 inline-flex items-center group-hover:translate-x-1 transition-transform">
                            View Bookings &rarr;
                        </a>
                    </div>
                </div>

                <!-- 2. Room Inventory Counter Card -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition flex flex-col justify-between group">
                    <div>
                        <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition-transform">
                            <i class="ri-hotel-line"></i>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900">Room Categories</h3>
                        <p class="text-slate-500 text-sm mt-1 leading-relaxed">
                            We currently feature {{ $roomTypes->count() }} room tiers with rates starting as low as ₱999/night.
                        </p>
                    </div>
                    <div class="mt-5 pt-4 border-t border-slate-100">
                        <a href="#rooms-section" class="text-amber-600 text-sm font-semibold hover:text-amber-800 inline-flex items-center group-hover:translate-x-1 transition-transform">
                            Check Availability &darr;
                        </a>
                    </div>
                </div>

                <!-- 3. Profile & Security Card -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition flex flex-col justify-between group">
                    <div>
                        <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition-transform">
                            <i class="ri-shield-user-line"></i>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900">Account Security</h3>
                        <p class="text-slate-500 text-sm mt-1 leading-relaxed">
                            Update your login credentials, contact phone, or review account permissions anytime.
                        </p>
                    </div>
                    <div class="mt-5 pt-4 border-t border-slate-100">
                        <a href="{{ route('profile.edit') }}" class="text-emerald-600 text-sm font-semibold hover:text-emerald-800 inline-flex items-center group-hover:translate-x-1 transition-transform">
                            Manage Account &rarr;
                        </a>
                    </div>
                </div>
            </div>
            <!-- Showcase of Imagined Hotel Rooms -->
             <div id="rooms-section" class="mt-8">
                @include('components.rooms-section')
             </div>
            <!-- Room Management Showcase: Dynamic Room Inventory Catalog -->
            <div id="rooms-section" class="space-y-6 pt-4">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h3 class="text-2xl font-bold text-slate-900">Available Rooms & Suites</h3>
                        <p class="text-slate-500 text-sm mt-1">
                            Availabilty and Pricing of rooms.
                        </p>
                    </div>
                    
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @forelse($roomTypes as $type)
                        <div class="bg-white rounded-2xl border border-slate-200 shadow-xs hover:shadow-lg transition-all duration-300 flex flex-col justify-between overflow-hidden group">
                            <div class="p-5 flex-1 flex flex-col">
                                <div class="flex items-start justify-between gap-2 mb-3">
                                    <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-[#06923E] text-white">
                                        ₱{{ number_format($type->PricePerNight, 2) }}<span class="text-[10px] font-normal">/night</span>
                                    </span>

                                    @if(($type->available_rooms_count ?? 0) > 0)
                                        <span class="text-[11px] font-semibold px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            {{ $type->available_rooms_count }} Vacant
                                        </span>
                                    @else
                                        <span class="text-[11px] font-semibold px-2 py-0.5 rounded-full bg-rose-50 text-rose-700 border border-rose-200">
                                            Fully Booked
                                        </span>
                                    @endif
                                </div>

                                <h4 class="text-lg font-bold text-slate-900 group-hover:text-emerald-700 transition-colors">
                                    {{ $type->name }}
                                </h4>

                                <p class="text-xs text-slate-500 mt-1 flex items-center gap-1.5">
                                    <i class="ri-user-line text-slate-400"></i> Max Guests: {{ $type->maxGuest }}
                                </p>
                            </div>

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
                            <p>No room categories found in the database. Please seed or add room types in the admin panel.</p>
                        </div>
                    @endforelse
                </div>
                
            </div>
            

        </div>
    </div>
@endsection