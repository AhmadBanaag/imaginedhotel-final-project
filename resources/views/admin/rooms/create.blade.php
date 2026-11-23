@extends('layouts.admin')

@section('page-title', 'Add / Edit Room Unit')
@section('page-subtitle', 'Configure room numbers, category assignment, and maintenance flags')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-4">
        <a href="{{ route('admin.rooms.index') }}" class="text-xs font-semibold text-indigo-600 hover:underline">
            &larr; Back to 31 Rooms Inventory
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-2xs p-6 sm:p-8 space-y-6">
        <h2 class="text-lg font-bold text-slate-900 pb-3 border-b border-slate-100">Room Configuration Details</h2>

        <form action="{{ route('admin.rooms.index') }}" method="GET" class="space-y-4">
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Room Number / Identifier</label>
                <input type="text" name="room_number" required value="Room 106" placeholder="e.g. Room 106" class="w-full text-sm rounded-xl border-slate-200 focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Room Category</label>
                <select name="category" class="w-full text-sm rounded-xl border-slate-200 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="single">Single-bed room (₱999/night)</option>
                    <option value="double">Double-bed room (₱1,999/night)</option>
                    <option value="family">Family Room (₱2,999/night)</option>
                    <option value="superior">Superior Room (₱4,999/night)</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Floor / Wing</label>
                <input type="text" name="floor" value="1st Floor, East Wing" class="w-full text-sm rounded-xl border-slate-200 focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Availability Status</label>
                <select name="status" class="w-full text-sm rounded-xl border-slate-200 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="available">Available (Open for guest reservations)</option>
                    <option value="booked">Booked (Guest currently staying)</option>
                    <option value="unavailable">Unavailable (Under maintenance / hold by admin)</option>
                </select>
                <span class="block text-[11px] text-slate-400 mt-1">
                    *Note: Setting to 'Unavailable' prevents guests from booking this room.
                </span>
            </div>

            <div class="pt-4 border-t border-slate-100 flex gap-3">
                <button type="submit" class="flex-1 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-xs transition">
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
