<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>
            <div class="flex space-x-3">
                <a href="{{ route('rooms.index') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md text-xs font-semibold text-white uppercase tracking-widest hover:bg-indigo-700">
                    {{ __('Book a Room') }}
                </a>
                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md text-xs font-semibold text-white uppercase tracking-widest hover:bg-gray-700">
                    {{ __('Admin Portal') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Welcome Banner -->
            <div class="bg-white overflow-hidden shadow-xs sm:rounded-lg p-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900">
                            Welcome back, {{ Auth::user()->name }}!
                        </h3>
                        <p class="text-gray-600 mt-1">
                            Manage your stays, explore available hotel rooms, or access the admin backoffice.
                        </p>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                            Active Account
                        </span>
                    </div>
                </div>
            </div>

            <!-- Quick Navigation Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- My Bookings Card -->
                <div class="bg-white p-6 rounded-lg shadow-xs border border-gray-100 hover:shadow-md transition">
                    <div class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-lg flex items-center justify-center text-2xl mb-4">
                        <i class="ri-calendar-check-line"></i>
                    </div>
                    <h4 class="text-lg font-semibold text-gray-900">My Reservations</h4>
                    <p class="text-gray-500 text-sm mt-1 mb-4">
                        View booking details, download printable E-receipts, or manage check-in dates.
                    </p>
                    <a href="{{ route('guest.reservations.index') }}" class="text-indigo-600 text-sm font-medium hover:text-indigo-800 inline-flex items-center">
                        View Bookings &rarr;
                    </a>
                </div>

                <!-- Room Catalog Card -->
                <div class="bg-white p-6 rounded-lg shadow-xs border border-gray-100 hover:shadow-md transition">
                    <div class="w-12 h-12 bg-amber-100 text-amber-600 rounded-lg flex items-center justify-center text-2xl mb-4">
                        <i class="ri-hotel-bed-line"></i>
                    </div>
                    <h4 class="text-lg font-semibold text-gray-900">Browse Available Rooms</h4>
                    <p class="text-gray-500 text-sm mt-1 mb-4">
                        Explore Single, Double, Family, and Deluxe rooms with prices starting from ₱999/night.
                    </p>
                    <a href="{{ route('rooms.index') }}" class="text-indigo-600 text-sm font-medium hover:text-indigo-800 inline-flex items-center">
                        Find Rooms &rarr;
                    </a>
                </div>

                <!-- Backoffice Hub Card -->
                <div class="bg-white p-6 rounded-lg shadow-xs border border-gray-100 hover:shadow-md transition">
                    <div class="w-12 h-12 bg-purple-100 text-purple-600 rounded-lg flex items-center justify-center text-2xl mb-4">
                        <i class="ri-shield-user-line"></i>
                    </div>
                    <h4 class="text-lg font-semibold text-gray-900">Admin & Front Desk</h4>
                    <p class="text-gray-500 text-sm mt-1 mb-4">
                        Check guests in/out, verify OTC & E-wallet payments, log No-Shows, and review reports.
                    </p>
                    <a href="{{ route('admin.dashboard') }}" class="text-indigo-600 text-sm font-medium hover:text-indigo-800 inline-flex items-center">
                        Open Front Desk &rarr;
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
