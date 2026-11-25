@extends('layouts.admin')

@section('page-subtitle', 'Configure Room Unit')

@section('content')
<div class="max-w-3xl mx-auto space-y-6" x-data="{
    roomNumber: 'Room 106',
    category: 'single',
    floor: '1st Floor, East Wing',
    status: 'available',
    saved: false,
    categories: {
        single: { name: 'Single-bed Room', rate: '₱999/night', specs: 'Single bed, Storage, AC, Free WiFi, Flat Screen TV, Bathroom with Shower & Toiletries' },
        double: { name: 'Double-bed Room', rate: '₱1,999/night', specs: 'Double bed, Wardrobe storage, AC, Free WiFi, Flat Screen TV, Shower & Toiletries' },
        family: { name: 'Family Room', rate: '₱2,999/night', specs: '2 Double-beds, 1 Single-large bed, Baby Crib, AC, Free WiFi, Flat Screen TV' },
        superior: { name: 'Superior Room (VIP)', rate: '₱4,999/night', specs: '2 Double-beds, 1 Double-large bed, Massage Chairs, Living Room, Balcony, Fridge, Washer, Microwave' }
    }
}">
    <div>
        <a href="{{ route('admin.rooms.index') }}" class="text-xs font-semibold text-[#06923E] hover:underline inline-flex items-center gap-1">
            &larr; Back to 31 Rooms Inventory
        </a>
    </div>

    <div x-show="saved" x-cloak class="bg-emerald-50 border border-emerald-200 rounded-2xl p-4 flex items-center justify-between text-xs text-emerald-900">
        <div class="flex items-center gap-2">
            <i class="ri-checkbox-circle-line text-lg text-[#06923E]"></i>
            <span>Configuration preview saved for <strong x-text="roomNumber"></strong> (<span x-text="categories[category].name"></span> — <span class="uppercase" x-text="status"></span>).</span>
        </div>
        <button type="button" @click="saved = false" class="text-emerald-700 hover:text-emerald-950"><i class="ri-close-line text-base"></i></button>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-2xs p-6 sm:p-8 space-y-6">
        <h2 class="text-lg font-bold text-slate-900 pb-3 border-b border-slate-100">Room Configuration Details</h2>

        <form @submit.prevent="saved = true" class="space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Room Number / Identifier</label>
                    <input type="text" x-model="roomNumber" required placeholder="e.g. Room 106" class="w-full text-sm rounded-xl border-slate-200 focus:ring-[#EDC92C] focus:border-[#EDC92C]">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Floor / Wing</label>
                    <input type="text" x-model="floor" class="w-full text-sm rounded-xl border-slate-200 focus:ring-[#EDC92C] focus:border-[#EDC92C]">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Room Category</label>
                    <select x-model="category" class="w-full text-sm rounded-xl border-slate-200 focus:ring-[#EDC92C] focus:border-[#EDC92C]">
                        <option value="single">Single-bed Room (₱999/night)</option>
                        <option value="double">Double-bed Room (₱1,999/night)</option>
                        <option value="family">Family Room (₱2,999/night)</option>
                        <option value="superior">Superior Room (₱4,999/night)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Availability Status</label>
                    <select x-model="status" class="w-full text-sm rounded-xl border-slate-200 focus:ring-[#EDC92C] focus:border-[#EDC92C]">
                        <option value="available">Available (Open for guest reservations)</option>
                        <option value="booked">Booked (Guest currently staying)</option>
                        <option value="unavailable">Unavailable (Under maintenance / hold)</option>
                    </select>
                </div>
            </div>

            <!-- Live Category Preview -->
            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 text-xs space-y-1">
                <div class="flex items-center justify-between">
                    <span class="font-bold text-slate-900" x-text="categories[category].name"></span>
                    <span class="font-bold text-[#06923E]" x-text="categories[category].rate"></span>
                </div>
                <p class="text-slate-500" x-text="categories[category].specs"></p>
            </div>

            <div class="pt-4 border-t border-slate-100 flex gap-3">
                <button type="submit" class="flex-1 py-2.5 rounded-xl bg-[#06923E] hover:bg-[#057a34] text-white font-semibold text-xs transition">
                    Save Room Unit
                </button>
                <a href="{{ route('admin.rooms.index') }}" class="py-2.5 px-4 rounded-xl border border-slate-200 text-slate-700 text-xs font-semibold hover:bg-slate-50 transition">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
