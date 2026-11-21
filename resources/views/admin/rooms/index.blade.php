@extends('layouts.admin')

@section('page-title', '31 Rooms Inventory')
@section('page-subtitle', 'Manage physical hotel rooms, assign categories, and update availability status')

@section('content')
<div class="space-y-6" x-data="{
    filterCategory: '',
    filterStatus: ''
}">
    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
        <div class="flex flex-wrap gap-2 text-xs">
            <button @click="filterCategory = ''" :class="filterCategory === '' ? 'bg-indigo-600 text-white' : 'bg-slate-100 text-slate-700'" class="px-3 py-1.5 rounded-lg font-semibold transition">
                All (31 Units)
            </button>
            <button @click="filterCategory = 'Single'" :class="filterCategory === 'Single' ? 'bg-indigo-600 text-white' : 'bg-slate-100 text-slate-700'" class="px-3 py-1.5 rounded-lg font-semibold transition">
                Single-bed (15)
            </button>
            <button @click="filterCategory = 'Double'" :class="filterCategory === 'Double' ? 'bg-indigo-600 text-white' : 'bg-slate-100 text-slate-700'" class="px-3 py-1.5 rounded-lg font-semibold transition">
                Double-bed (10)
            </button>
            <button @click="filterCategory = 'Family'" :class="filterCategory === 'Family' ? 'bg-indigo-600 text-white' : 'bg-slate-100 text-slate-700'" class="px-3 py-1.5 rounded-lg font-semibold transition">
                Family Room (5)
            </button>
            <button @click="filterCategory = 'Superior'" :class="filterCategory === 'Superior' ? 'bg-indigo-600 text-white' : 'bg-slate-100 text-slate-700'" class="px-3 py-1.5 rounded-lg font-semibold transition">
                Superior Room (1)
            </button>
        </div>
        <div>
            <a href="{{ route('admin.rooms.create') }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-xs rounded-xl shadow-xs transition inline-flex items-center gap-1.5">
                <i class="ri-add-line"></i> Add New Room Unit
            </a>
        </div>
    </div>

    <!-- Inventory Table Card -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 uppercase tracking-wider font-semibold">
                        <th class="py-3.5 px-5">Room Number</th>
                        <th class="py-3.5 px-5">Category / Type</th>
                        <th class="py-3.5 px-5">Nightly Rate</th>
                        <th class="py-3.5 px-5">Bed Configuration</th>
                        <th class="py-3.5 px-5">Current Availability</th>
                        <th class="py-3.5 px-5 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    <!-- Single Bed Rooms Sample -->
                    @for ($i = 101; $i <= 105; $i++)
                    <tr class="hover:bg-slate-50/80 transition" x-show="filterCategory === '' || filterCategory === 'Single'">
                        <td class="py-3 px-5 font-mono font-bold text-slate-900">Room {{ $i }}</td>
                        <td class="py-3 px-5">Single-bed room</td>
                        <td class="py-3 px-5 font-semibold text-slate-900">₱999</td>
                        <td class="py-3 px-5 text-slate-500">1 Single bed, Storage, AC</td>
                        <td class="py-3 px-5">
                            @if ($i == 102)
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-100 text-blue-800">Booked</span>
                            @elseif ($i == 105)
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800">Unavailable (Cleaning)</span>
                            @else
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">Available</span>
                            @endif
                        </td>
                        <td class="py-3 px-5 text-right space-x-2">
                            <a href="{{ route('admin.rooms.create') }}" class="text-indigo-600 hover:underline font-semibold">Edit</a>
                            <button onclick="alert('Room status toggled.')" class="text-slate-400 hover:text-slate-700">Toggle Status</button>
                        </td>
                    </tr>
                    @endfor

                    <!-- Double Bed Sample -->
                    @for ($i = 201; $i <= 204; $i++)
                    <tr class="hover:bg-slate-50/80 transition" x-show="filterCategory === '' || filterCategory === 'Double'">
                        <td class="py-3 px-5 font-mono font-bold text-slate-900">Room {{ $i }}</td>
                        <td class="py-3 px-5">Double-bed room</td>
                        <td class="py-3 px-5 font-semibold text-slate-900">₱1,999</td>
                        <td class="py-3 px-5 text-slate-500">1 Double bed, Wardrobe, AC</td>
                        <td class="py-3 px-5">
                            @if ($i == 201)
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-100 text-blue-800">Booked</span>
                            @else
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">Available</span>
                            @endif
                        </td>
                        <td class="py-3 px-5 text-right space-x-2">
                            <a href="{{ route('admin.rooms.create') }}" class="text-indigo-600 hover:underline font-semibold">Edit</a>
                            <button onclick="alert('Room status toggled.')" class="text-slate-400 hover:text-slate-700">Toggle Status</button>
                        </td>
                    </tr>
                    @endfor

                    <!-- Family Room Sample -->
                    <tr class="hover:bg-slate-50/80 transition" x-show="filterCategory === '' || filterCategory === 'Family'">
                        <td class="py-3 px-5 font-mono font-bold text-slate-900">Room 301</td>
                        <td class="py-3 px-5">Family Room</td>
                        <td class="py-3 px-5 font-semibold text-slate-900">₱2,999</td>
                        <td class="py-3 px-5 text-slate-500">2 Double-beds, 1 Single-large, Baby crib</td>
                        <td class="py-3 px-5">
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-100 text-blue-800">Booked</span>
                        </td>
                        <td class="py-3 px-5 text-right space-x-2">
                            <a href="{{ route('admin.rooms.create') }}" class="text-indigo-600 hover:underline font-semibold">Edit</a>
                            <button onclick="alert('Room status toggled.')" class="text-slate-400 hover:text-slate-700">Toggle Status</button>
                        </td>
                    </tr>

                    <!-- Superior Room (1 Unit) -->
                    <tr class="hover:bg-slate-50/80 transition bg-amber-50/30" x-show="filterCategory === '' || filterCategory === 'Superior'">
                        <td class="py-3 px-5 font-mono font-bold text-amber-700">Room 401 (VIP Suite)</td>
                        <td class="py-3 px-5 font-bold text-slate-900">Superior Room</td>
                        <td class="py-3 px-5 font-bold text-indigo-700">₱4,999</td>
                        <td class="py-3 px-5 text-slate-600">2 Double-beds, 1 Double-large, Massage Chairs, Living Room, Balcony</td>
                        <td class="py-3 px-5">
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">Available</span>
                        </td>
                        <td class="py-3 px-5 text-right space-x-2">
                            <a href="{{ route('admin.rooms.create') }}" class="text-indigo-600 hover:underline font-semibold">Edit</a>
                            <button onclick="alert('Room status toggled.')" class="text-slate-400 hover:text-slate-700">Toggle Status</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
