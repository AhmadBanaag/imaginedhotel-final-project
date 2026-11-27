@extends('layouts.admin')

@section('page-title', 'Add New Room Unit')
@section('page-subtitle', 'Configure room numbers, category assignment, and maintenance flags')

@section('content')
@php
    $categoryMap = $roomTypes->mapWithKeys(function ($type) {
        $specs = $type->description
            ?? ($type->amenities ?? ('Max Capacity: ' . ($type->maxGuest ?? 1) . ' ' . \Illuminate\Support\Str::plural('Guest', $type->maxGuest ?? 1)));

        return [
            (string) $type->room_type_id => [
                'name' => $type->name,
                'rate' => '₱' . number_format($type->PricePerNight ?? 0, 2) . '/night',
                'specs' => $specs,
            ],
        ];
    });
@endphp

<div class="max-w-3xl mx-auto space-y-6" x-data="{
    selectedTypeId: @js((string) old('room_type_id', '')),
    categories: @js($categoryMap)
}">
    <div>
        <a href="{{ route('admin.rooms.index') }}" class="text-xs font-semibold text-[#06923E] hover:underline inline-flex items-center gap-1">
            &larr; Back to Rooms Inventory
        </a>
    </div>

    <!-- Validation Errors Display -->
    @if ($errors->any())
        <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs shadow-2xs">
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-2xl border border-slate-200 shadow-2xs p-6 sm:p-8 space-y-6">
        <h2 class="text-lg font-bold text-slate-900 pb-3 border-b border-slate-100">Room Configuration Details</h2>

        <form action="{{ route('admin.rooms.store') }}" method="POST" class="space-y-4">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Room Number -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Room Number / Identifier *</label>
                    <input type="text" name="room_number" required value="{{ old('room_number') }}" placeholder="e.g. Room 105 or 105" class="w-full text-sm rounded-xl border-slate-200 focus:ring-[#EDC92C] focus:border-[#EDC92C]">
                </div>

                <!-- Floor / Wing -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Floor / Wing</label>
                    <input type="text" name="floor" value="{{ old('floor', '1st Floor') }}" placeholder="e.g. 1st Floor, East Wing" class="w-full text-sm rounded-xl border-slate-200 focus:ring-[#EDC92C] focus:border-[#EDC92C]">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Dynamic Room Category Dropdown -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Room Category / Type *</label>
                    <select name="room_type_id" x-model="selectedTypeId" required class="w-full text-sm rounded-xl border-slate-200 focus:ring-[#EDC92C] focus:border-[#EDC92C]">
                        <option value="">-- Select Room Category --</option>
                        @foreach($roomTypes as $type)
                            <option value="{{ $type->room_type_id }}" {{ old('room_type_id') == $type->room_type_id ? 'selected' : '' }}>
                                {{ $type->name }} (₱{{ number_format($type->PricePerNight, 2) }}/night)
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Availability Status -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Availability Status *</label>
                    <select name="status" required class="w-full text-sm rounded-xl border-slate-200 focus:ring-[#EDC92C] focus:border-[#EDC92C]">
                        <option value="available" {{ old('status', 'available') == 'available' ? 'selected' : '' }}>Available (Open for guest reservations)</option>
                        <option value="booked" {{ old('status') == 'booked' ? 'selected' : '' }}>Booked (Guest currently staying)</option>
                        <option value="unavailable" {{ old('status') == 'unavailable' ? 'selected' : '' }}>Unavailable (Under maintenance / hold by admin)</option>
                    </select>
                    <span class="block text-[11px] text-slate-400 mt-1">
                        *Note: Setting to 'Unavailable' hides this room from guest searches.
                    </span>
                </div>
            </div>

            <!-- Live Category Preview (Driven by $roomTypes) -->
            <div x-show="selectedTypeId && categories[selectedTypeId]" x-cloak class="p-4 rounded-xl bg-slate-50 border border-slate-200 text-xs space-y-1">
                <div class="flex items-center justify-between">
                    <span class="font-bold text-slate-900" x-text="categories[selectedTypeId]?.name"></span>
                    <span class="font-bold text-[#06923E]" x-text="categories[selectedTypeId]?.rate"></span>
                </div>
                <p class="text-slate-500" x-text="categories[selectedTypeId]?.specs"></p>
            </div>

            <!-- Submit & Cancel Buttons -->
            <div class="pt-4 border-t border-slate-100 flex gap-3">
                <button type="submit" class="flex-1 py-2.5 rounded-xl bg-[#06923E] hover:bg-[#057a34] text-white font-semibold text-xs transition cursor-pointer">
                    Save Room Unit
                </button>
                <a href="{{ route('admin.rooms.index') }}" class="py-2.5 px-4 rounded-xl border border-slate-200 text-slate-700 text-xs font-semibold hover:bg-slate-50 transition text-center">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection