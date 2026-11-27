@extends('layouts.admin')

@section('page-title', 'Rooms Inventory')
@section('page-subtitle', 'Manage physical hotel rooms, assign categories, and update availability status')

@section('content')
@php
    $totalRooms = $rooms->count();
    $availableCount = $rooms->filter(fn($r) => strtolower($r->status) === 'available')->count();
    $bookedCount = $rooms->filter(fn($r) => strtolower($r->status) === 'booked')->count();
    $unavailableCount = $rooms->filter(fn($r) => !in_array(strtolower($r->status), ['available', 'booked']))->count();

    $singleCount = $rooms->filter(fn($r) => str_contains(strtolower($r->roomType->name ?? ''), 'single'))->count();
    $doubleCount = $rooms->filter(fn($r) => str_contains(strtolower($r->roomType->name ?? ''), 'double'))->count();
    $familyCount = $rooms->filter(fn($r) => str_contains(strtolower($r->roomType->name ?? ''), 'family'))->count();
    $superiorCount = $rooms->filter(fn($r) => str_contains(strtolower($r->roomType->name ?? ''), 'superior') || str_contains(strtolower($r->roomType->name ?? ''), 'deluxe') || str_contains(strtolower($r->roomType->name ?? ''), 'suite'))->count();
@endphp

<div class="space-y-6" x-data="{
    filterCategory: '',
    filterStatus: '',
    searchQuery: '',
    matchesFilter(roomNumber, categoryName, status) {
        const q = this.searchQuery.trim().toLowerCase();
        const cat = (categoryName || '').toLowerCase();
        const st = (status || '').toLowerCase();

        const matchCat = !this.filterCategory || cat.includes(this.filterCategory);
        const matchStatus = !this.filterStatus || (
            this.filterStatus === 'unavailable'
                ? !['available', 'booked'].includes(st)
                : st === this.filterStatus
        );
        const matchSearch = !q || roomNumber.toLowerCase().includes(q) || cat.includes(q);

        return matchCat && matchStatus && matchSearch;
    }
}">
    <!-- Success Notification Flash Message -->
    @if(session('success'))
        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold flex items-center justify-between shadow-2xs">
            <div class="flex items-center gap-2">
                <i class="ri-checkbox-circle-line text-[#06923E] text-base"></i>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    <!-- Live KPI Strip (Calculated from Database) -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-2xs flex items-center justify-between">
            <div>
                <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider block">Total Inventory</span>
                <span class="text-xl font-bold text-slate-900 mt-0.5 block">{{ $totalRooms }} {{ Str::plural('Room', $totalRooms) }}</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-[#EDC92C]/25 text-[#EDC92C] flex items-center justify-center text-xl">
                <i class="ri-hotel-bed-line"></i>
            </div>
        </div>
        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-2xs flex items-center justify-between">
            <div>
                <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider block">Available</span>
                <span class="text-xl font-bold text-[#06923E] mt-0.5 block">{{ $availableCount }} {{ Str::plural('Room', $availableCount) }}</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-[#06923E] flex items-center justify-center text-xl">
                <i class="ri-checkbox-circle-line"></i>
            </div>
        </div>
        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-2xs flex items-center justify-between">
            <div>
                <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider block">Booked</span>
                <span class="text-xl font-bold text-blue-600 mt-0.5 block">{{ $bookedCount }} {{ Str::plural('Room', $bookedCount) }}</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl">
                <i class="ri-user-shared-line"></i>
            </div>
        </div>
        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-2xs flex items-center justify-between">
            <div>
                <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider block">Unavailable</span>
                <span class="text-xl font-bold text-red-500 mt-0.5 block">{{ $unavailableCount }} {{ Str::plural('Room', $unavailableCount) }}</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-red-50 text-red-500 flex items-center justify-center text-xl">
                <i class="ri-tools-line"></i>
            </div>
        </div>
    </div>

    <!-- Top Filter & Action Bar -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs space-y-4">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
            <div class="flex flex-wrap gap-2 text-xs">
                <button type="button" @click="filterCategory = ''" :class="filterCategory === '' ? 'bg-slate-900 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200'" class="px-3 py-1.5 rounded-lg font-semibold transition cursor-pointer">
                    All ({{ $totalRooms }})
                </button>
                <button type="button" @click="filterCategory = 'single'" :class="filterCategory === 'single' ? 'bg-slate-900 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200'" class="px-3 py-1.5 rounded-lg font-semibold transition cursor-pointer">
                    Single-bed ({{ $singleCount }})
                </button>
                <button type="button" @click="filterCategory = 'double'" :class="filterCategory === 'double' ? 'bg-slate-900 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200'" class="px-3 py-1.5 rounded-lg font-semibold transition cursor-pointer">
                    Double-bed ({{ $doubleCount }})
                </button>
                <button type="button" @click="filterCategory = 'family'" :class="filterCategory === 'family' ? 'bg-slate-900 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200'" class="px-3 py-1.5 rounded-lg font-semibold transition cursor-pointer">
                    Family Room ({{ $familyCount }})
                </button>
                <button type="button" @click="filterCategory = 'superior'" :class="filterCategory === 'superior' ? 'bg-[#EDC92C] text-slate-950' : 'bg-slate-100 text-slate-700 hover:bg-slate-200'" class="px-3 py-1.5 rounded-lg font-semibold transition cursor-pointer">
                    Superior / Suite ({{ $superiorCount }})
                </button>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <div class="relative">
                    <i class="ri-search-line absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    <input type="text" x-model="searchQuery" placeholder="Search room no. or type..." class="pl-8 pr-3 py-1.5 text-xs rounded-xl border-slate-200 focus:ring-[#EDC92C] focus:border-[#EDC92C]">
                </div>
                <select x-model="filterStatus" class="text-xs text-left rounded-xl border-slate-200 focus:ring-[#EDC92C] focus:border-[#EDC92C] py-1.5 pl-3 pr-6">
                    <option value="">All Statuses</option>
                    <option value="available">Available</option>
                    <option value="booked">Booked</option>
                    <option value="unavailable">Unavailable</option>
                </select>
                <a href="{{ route('admin.rooms.create') }}" class="px-4 py-2 bg-[#06923E] hover:bg-[#EDC92C] text-white hover:text-slate-950 font-semibold text-xs rounded-xl shadow-2xs transition inline-flex items-center gap-1.5">
                    <i class="ri-add-line"></i> Add New Room Unit
                </a>
            </div>
        </div>
    </div>

    <!-- Inventory Table Card -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-2xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 uppercase tracking-wider font-semibold">
                        <th class="py-3.5 px-5">Room Number</th>
                        <th class="py-3.5 px-5">Category / Type</th>
                        <th class="py-3.5 px-5">Nightly Rate</th>
                        <th class="py-3.5 px-5">Max Capacity</th>
                        <th class="py-3.5 px-5">Current Availability</th>
                        <th class="py-3.5 px-5 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse ($rooms as $room)
                        @php
                            $formattedNumber = str_starts_with(strtolower($room->room_number), 'room')
                                ? $room->room_number
                                : 'Room ' . $room->room_number;
                            $categoryName = $room->roomType->name ?? 'Unassigned';
                            $isSuperior = str_contains(strtolower($categoryName), 'superior') || str_contains(strtolower($categoryName), 'suite');
                            $statusLower = strtolower($room->status);
                        @endphp
                        <tr class="hover:bg-slate-50/80 transition {{ $isSuperior ? 'bg-amber-50/30' : '' }}"
                            x-show="matchesFilter(@js($formattedNumber), @js($categoryName), @js($statusLower))">
                            <td class="py-3 px-5 font-mono font-bold {{ $isSuperior ? 'text-amber-700' : 'text-slate-900' }}">
                                {{ $formattedNumber }}
                            </td>
                            <td class="py-3 px-5 font-semibold text-slate-900">
                                {{ $categoryName }}
                            </td>
                            <td class="py-3 px-5 font-bold text-slate-900">
                                ₱{{ number_format($room->roomType->PricePerNight ?? 0, 2) }}
                            </td>
                            <td class="py-3 px-5 text-slate-500">
                                {{ $room->roomType->maxGuest ?? 1 }} {{ Str::plural('Guest', $room->roomType->maxGuest ?? 1) }}
                            </td>
                            <td class="py-3 px-5">
                                @if ($statusLower === 'available')
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                        Available
                                    </span>
                                @elseif ($statusLower === 'booked')
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-100 text-blue-800">
                                        Booked
                                    </span>
                                @else
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-red-100 text-red-700">
                                        Unavailable (Maintenance)
                                    </span>
                                @endif
                            </td>
                            <td class="py-3 px-5 text-right space-x-3 whitespace-nowrap">
                                <!-- Edit Button -->
                                <a href="{{ route('admin.rooms.edit', $room->room_id) }}" class="text-[#06923E] hover:underline font-semibold text-xs">
                                    Edit
                                </a>

                                <!-- Delete Button -->
                                <form action="{{ route('admin.rooms.destroy', $room->room_id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this room?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-rose-600 hover:text-rose-900 hover:underline font-semibold cursor-pointer text-xs">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-10 text-center text-slate-400">
                                <i class="ri-hotel-bed-line text-3xl block mb-2 text-slate-300"></i>
                                No rooms found in the inventory. Click <strong>"Add New Room Unit"</strong> to create one.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection