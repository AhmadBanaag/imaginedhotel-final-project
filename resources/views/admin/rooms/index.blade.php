@extends('layouts.admin')

@section('page-subtitle', '31 Rooms Inventory')

@section('content')
<div class="space-y-6" x-data="{
    filterCategory: '',
    filterStatus: '',
    searchQuery: '',
    rooms: [
        @for ($i = 101; $i <= 115; $i++)
            @php
                $status = in_array($i, [102, 106, 111, 114]) ? 'booked' : (in_array($i, [105, 110, 115]) ? 'unavailable' : 'available');
                $note = $status === 'unavailable' ? 'Housekeeping / Maintenance' : ($status === 'booked' ? 'Occupied by Guest' : 'Ready for Check-in');
            @endphp
            { number: 'Room {{ $i }}', floor: '1st Floor', category: 'Single', categoryLabel: 'Single-bed Room', rate: '₱999', beds: '1 Single bed, Storage, AC, TV', status: '{{ $status }}', note: '{{ $note }}' },
        @endfor
        @for ($i = 201; $i <= 210; $i++)
            @php
                $status = in_array($i, [201, 204, 207, 209]) ? 'booked' : (in_array($i, [206, 210]) ? 'unavailable' : 'available');
                $note = $status === 'unavailable' ? 'AC Servicing / Hold' : ($status === 'booked' ? 'Occupied by Guest' : 'Ready for Check-in');
            @endphp
            { number: 'Room {{ $i }}', floor: '2nd Floor', category: 'Double', categoryLabel: 'Double-bed Room', rate: '₱1,999', beds: '1 Double bed, Wardrobe, AC, TV', status: '{{ $status }}', note: '{{ $note }}' },
        @endfor
        @for ($i = 301; $i <= 305; $i++)
            @php
                $status = in_array($i, [301, 304]) ? 'booked' : ($i === 305 ? 'unavailable' : 'available');
                $note = $status === 'unavailable' ? 'Deep Cleaning' : ($status === 'booked' ? 'Occupied by Guest' : 'Ready for Check-in');
            @endphp
            { number: 'Room {{ $i }}', floor: '3rd Floor', category: 'Family', categoryLabel: 'Family Room', rate: '₱2,999', beds: '2 Double-beds, 1 Single-large, Baby Crib', status: '{{ $status }}', note: '{{ $note }}' },
        @endfor
        { number: 'Room 401 (VIP Suite)', floor: '4th Floor', category: 'Superior', categoryLabel: 'Superior Room', rate: '₱4,999', beds: '2 Double-beds, 1 Double-large, Massage Chairs, Living Room, Balcony', status: 'available', note: 'VIP Suite Ready' }
    ],
    get filteredRooms() {
        const q = this.searchQuery.trim().toLowerCase();
        return this.rooms.filter(r => {
            const matchCat = !this.filterCategory || r.category === this.filterCategory;
            const matchStatus = !this.filterStatus || r.status === this.filterStatus;
            const matchSearch = !q || r.number.toLowerCase().includes(q) || r.categoryLabel.toLowerCase().includes(q) || r.floor.toLowerCase().includes(q);
            return matchCat && matchStatus && matchSearch;
        });
    },
    countByStatus(s) {
        return this.rooms.filter(r => r.status === s).length;
    },
    cycleStatus(room) {
        const order = ['available', 'booked', 'unavailable'];
        const next = order[(order.indexOf(room.status) + 1) % order.length];
        room.status = next;
        room.note = next === 'available' ? 'Ready for Check-in' : (next === 'booked' ? 'Occupied by Guest' : 'Maintenance / Hold');
    },
    statusLabel(s) {
        if (s === 'available') return 'Available';
        if (s === 'booked') return 'Booked';
        return 'Unavailable (Hold)';
    },
    statusBadgeClass(s) {
        if (s === 'available') return 'bg-emerald-100 text-emerald-800';
        if (s === 'booked') return 'bg-blue-100 text-blue-800';
        return 'bg-red-100 text-red-700';
    }
}">
    <!-- Live KPI Strip (Matches Main Dashboard Totals) -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-2xs flex items-center justify-between">
            <div>
                <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider block">Total Inventory</span>
                <span class="text-xl font-bold text-slate-900 mt-0.5 block" x-text="rooms.length + ' Units'"></span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-[#EDC92C]/25 text-[#EDC92C] flex items-center justify-center text-xl">
                <i class="ri-hotel-bed-line"></i>
            </div>
        </div>
        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-2xs flex items-center justify-between">
            <div>
                <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider block">Available</span>
                <span class="text-xl font-bold text-[#06923E] mt-0.5 block" x-text="countByStatus('available') + ' Rooms'"></span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-[#06923E] flex items-center justify-center text-xl">
                <i class="ri-checkbox-circle-line"></i>
            </div>
        </div>
        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-2xs flex items-center justify-between">
            <div>
                <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider block">Booked</span>
                <span class="text-xl font-bold text-blue-600 mt-0.5 block" x-text="countByStatus('booked') + ' Rooms'"></span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl">
                <i class="ri-user-shared-line"></i>
            </div>
        </div>
        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-2xs flex items-center justify-between">
            <div>
                <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider block">Unavailable</span>
                <span class="text-xl font-bold text-red-500 mt-0.5 block" x-text="countByStatus('unavailable') + ' Rooms'"></span>
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
                <button @click="filterCategory = ''" :class="filterCategory === '' ? 'bg-slate-900 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200'" class="px-3 py-1.5 rounded-lg font-semibold transition">
                    All (31)
                </button>
                <button @click="filterCategory = 'Single'" :class="filterCategory === 'Single' ? 'bg-slate-900 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200'" class="px-3 py-1.5 rounded-lg font-semibold transition">
                    Single-bed (15)
                </button>
                <button @click="filterCategory = 'Double'" :class="filterCategory === 'Double' ? 'bg-slate-900 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200'" class="px-3 py-1.5 rounded-lg font-semibold transition">
                    Double-bed (10)
                </button>
                <button @click="filterCategory = 'Family'" :class="filterCategory === 'Family' ? 'bg-slate-900 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200'" class="px-3 py-1.5 rounded-lg font-semibold transition">
                    Family Room (5)
                </button>
                <button @click="filterCategory = 'Superior'" :class="filterCategory === 'Superior' ? 'bg-[#EDC92C] text-slate-950' : 'bg-slate-100 text-slate-700 hover:bg-slate-200'" class="px-3 py-1.5 rounded-lg font-semibold transition">
                    Superior VIP (1)
                </button>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <div class="relative">
                    <i class="ri-search-line absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    <input type="text" x-model="searchQuery" placeholder="Search room no. or floor..." class="pl-8 pr-3 py-1.5 text-xs rounded-xl border-slate-200 focus:ring-[#EDC92C] focus:border-[#EDC92C]">
                </div>
                <select x-model="filterStatus" class="text-xs rounded-xl border-slate-200 focus:ring-[#EDC92C] focus:border-[#EDC92C] py-1.5 px-3">
                    <option value="">All Statuses</option>
                    <option value="available">Available</option>
                    <option value="booked">Booked</option>
                    <option value="unavailable">Unavailable</option>
                </select>
                <a href="{{ route('admin.rooms.create') }}" class="px-4 py-2 bg-[#06923E] hover:bg-[#057a34] text-white font-semibold text-xs rounded-xl shadow-2xs transition inline-flex items-center gap-1.5">
                    <i class="ri-add-line"></i> Add Room Unit
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
                        <th class="py-3.5 px-5">Category / Floor</th>
                        <th class="py-3.5 px-5">Nightly Rate</th>
                        <th class="py-3.5 px-5">Bed Configuration &amp; Amenities</th>
                        <th class="py-3.5 px-5">Current Status</th>
                        <th class="py-3.5 px-5 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    <template x-for="room in filteredRooms" :key="room.number">
                        <tr class="hover:bg-slate-50/80 transition" :class="room.category === 'Superior' ? 'bg-amber-50/30' : ''">
                            <td class="py-3 px-5 font-mono font-bold" :class="room.category === 'Superior' ? 'text-amber-700' : 'text-slate-900'" x-text="room.number"></td>
                            <td class="py-3 px-5">
                                <span class="font-semibold text-slate-900 block" x-text="room.categoryLabel"></span>
                                <span class="text-[10px] text-slate-400" x-text="room.floor"></span>
                            </td>
                            <td class="py-3 px-5 font-bold text-slate-900" x-text="room.rate"></td>
                            <td class="py-3 px-5 text-slate-500">
                                <span x-text="room.beds"></span>
                                <span class="block text-[10px] text-slate-400 mt-0.5" x-text="room.note"></span>
                            </td>
                            <td class="py-3 px-5">
                                <span :class="statusBadgeClass(room.status)" class="px-2.5 py-0.5 rounded-full text-[10px] font-bold" x-text="statusLabel(room.status)"></span>
                            </td>
                            <td class="py-3 px-5 text-right space-x-2 whitespace-nowrap">
                                <a href="{{ route('admin.rooms.create') }}" class="text-[#06923E] hover:underline font-semibold">Edit</a>
                                <button type="button" @click="cycleStatus(room)" class="px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-[#EDC92C] text-slate-700 hover:text-slate-950 font-semibold transition">
                                    Cycle Status
                                </button>
                            </td>
                        </tr>
                    </template>
                    <tr x-show="filteredRooms.length === 0">
                        <td colspan="6" class="py-10 text-center text-slate-400">
                            No rooms match your filter criteria.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
