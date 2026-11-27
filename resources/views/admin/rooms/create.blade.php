@extends('layouts.admin')

@section('page-title', 'Add New Room Unit')
@section('page-subtitle', 'Configure room numbers, category assignment, and maintenance flags')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-4">
        <a href="{{ route('admin.rooms.index') }}" class="text-xs font-semibold text-indigo-600 hover:underline">
            &larr; Back to Rooms Inventory
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-2xs p-6 sm:p-8 space-y-6">
        <h2 class="text-lg font-bold text-slate-900 pb-3 border-b border-slate-100">Room Configuration Details</h2>

        <!-- Validation Errors Display -->
        @if ($errors->any())
            <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.rooms.store') }}" method="POST" class="space-y-4">
            @csrf
            
            <!-- Room Number -->
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Room Number / Identifier *</label>
                <input type="text" name="room_number" required value="{{ old('room_number') }}" placeholder="e.g. Room 105 or 105" class="w-full text-sm rounded-xl border-slate-200 focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <!-- Dynamic Room Category Dropdown -->
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Room Category / Type *</label>
                <select name="room_type_id" required class="w-full text-sm rounded-xl border-slate-200 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">-- Select Room Category --</option>
                    @foreach($roomTypes as $type)
                        <option value="{{ $type->room_type_id }}" {{ old('room_type_id') == $type->room_type_id ? 'selected' : '' }}>
                            {{ $type->name }} (₱{{ number_format($type->PricePerNight, 2) }}/night)
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Floor / Wing -->
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Floor / Wing</label>
                <input type="text" name="floor" value="{{ old('floor', '1st Floor') }}" placeholder="e.g. 1st Floor, East Wing" class="w-full text-sm rounded-xl border-slate-200 focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <!-- Availability Status -->
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Availability Status *</label>
                <select name="status" required class="w-full text-sm rounded-xl border-slate-200 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Available (Open for guest reservations)</option>
                    <option value="booked" {{ old('status') == 'booked' ? 'selected' : '' }}>Booked (Guest currently staying)</option>
                    <option value="unavailable" {{ old('status') == 'unavailable' ? 'selected' : '' }}>Unavailable (Under maintenance / hold by admin)</option>
                </select>
                <span class="block text-[11px] text-slate-400 mt-1">
                    *Note: Setting to 'Unavailable' hides this room from guest searches.
                </span>
            </div>

            <!-- Submit & Cancel Buttons -->
            <div class="pt-4 border-t border-slate-100 flex gap-3">
                <button type="submit" class="flex-1 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-xs transition cursor-pointer">
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