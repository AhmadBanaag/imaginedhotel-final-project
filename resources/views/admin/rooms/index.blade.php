@extends('layouts.admin')

@section('page-title', 'Rooms Inventory')
@section('page-subtitle', 'Manage physical hotel rooms, assign categories, and update availability status')

@section('content')
<div class="space-y-6" x-data="{
    filterCategory: ''
}">
    <!-- Success Notification Flash Message -->
    @if(session('success'))
        <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold flex items-center justify-between">
            <div class="flex items-center gap-2">
                <i class="ri-checkbox-circle-line text-emerald-600 text-base"></i>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs">
        <div class="flex flex-wrap gap-2 text-xs">
            <button @click="filterCategory = ''" :class="filterCategory === '' ? 'bg-indigo-600 text-white' : 'bg-slate-100 text-slate-700'" class="px-3 py-1.5 rounded-lg font-semibold transition cursor-pointer">
                All ({{ $rooms->count() }})
            </button>
            <button @click="filterCategory = 'single'" :class="filterCategory === 'single' ? 'bg-indigo-600 text-white' : 'bg-slate-100 text-slate-700'" class="px-3 py-1.5 rounded-lg font-semibold transition cursor-pointer">
                Single-bed
            </button>
            <button @click="filterCategory = 'double'" :class="filterCategory === 'double' ? 'bg-indigo-600 text-white' : 'bg-slate-100 text-slate-700'" class="px-3 py-1.5 rounded-lg font-semibold transition cursor-pointer">
                Double-bed
            </button>
            <button @click="filterCategory = 'family'" :class="filterCategory === 'family' ? 'bg-indigo-600 text-white' : 'bg-slate-100 text-slate-700'" class="px-3 py-1.5 rounded-lg font-semibold transition cursor-pointer">
                Family Room
            </button>
            <button @click="filterCategory = 'deluxe'" :class="filterCategory === 'deluxe' ? 'bg-indigo-600 text-white' : 'bg-slate-100 text-slate-700'" class="px-3 py-1.5 rounded-lg font-semibold transition cursor-pointer">
                Deluxe Room
            </button>
        </div>
        <div>
            <a href="{{ route('admin.rooms.create') }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-xs rounded-xl shadow-2xs transition inline-flex items-center gap-1.5">
                <i class="ri-add-line"></i> Add New Room Unit
            </a>
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
                    <tr class="hover:bg-slate-50/80 transition" 
                        x-show="filterCategory === '' || '{{ strtolower($room->roomType->name ?? '') }}'.includes(filterCategory)">
                        <td class="py-3 px-5 font-mono font-bold text-slate-900">
                            {{ str_starts_with(strtolower($room->room_number), 'room') ? $room->room_number : 'Room ' . $room->room_number }}
                        </td>
                        <td class="py-3 px-5 font-medium text-slate-800">
                            {{ $room->roomType->name ?? 'Unassigned' }}
                        </td>
                        <td class="py-3 px-5 font-semibold text-slate-900">
                            ₱{{ number_format($room->roomType->PricePerNight ?? 0, 2) }}
                        </td>
                        <td class="py-3 px-5 text-slate-500">
                            {{ $room->roomType->maxGuest ?? 1 }} Guests
                        </td>
                        <td class="py-3 px-5">
                            @if (strtolower($room->status) === 'available')
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                    Available
                                </span>
                            @elseif (strtolower($room->status) === 'booked')
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-blue-100 text-blue-800">
                                    Booked
                                </span>
                            @else
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800">
                                    Unavailable (Maintenance)
                                </span>
                            @endif
                        </td>
                        <td class="py-3 px-5 text-right space-x-3">
                            <!-- Edit Button -->
                            <a href="{{ route('admin.rooms.edit', $room->room_id) }}" class="text-indigo-600 hover:text-indigo-900 hover:underline font-semibold text-xs">
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