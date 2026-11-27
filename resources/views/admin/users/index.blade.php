@extends('layouts.admin')

@section('page-title', 'Admin Dashboard')
@section('page-subtitle', 'Overview of room inventory, registered accounts, and guest reservation statuses')

@section('content')
@php
    // Live Room Inventory Counts
    $roomList = $rooms ?? \App\Models\Room::with('roomType')->get();
    $totalRoomsCount = $roomList->count();
    $availableRoomsCount = $roomList->filter(fn($r) => strtolower($r->status) === 'available')->count();
    $bookedRoomsCount = $roomList->filter(fn($r) => strtolower($r->status) === 'booked')->count();
    $unavailableRoomsCount = $roomList->filter(fn($r) => !in_array(strtolower($r->status), ['available', 'booked']))->count();

    // Prioritized Real User Records from Database
    $userList = $users ?? \App\Models\User::latest()->get();

    // Safe Reservation Lookup (Won't crash while teammate's Reservation table/model is still pending)
    $hasReservationsTable = class_exists(\App\Models\Reservation::class)
        && \Illuminate\Support\Facades\Schema::hasTable('reservations');

    $reservationsByUser = $hasReservationsTable
        ? \App\Models\Reservation::with('room.roomType')->latest()->get()->groupBy('user_id')
        : collect();
@endphp

<div class="space-y-6">
    <!-- Success Notification Flash Message -->
    @if(session('success'))
        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold flex items-center justify-between shadow-2xs">
            <div class="flex items-center gap-2">
                <i class="ri-checkbox-circle-line text-[#06923E] text-base"></i>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    <!-- Top KPI Metric Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- Card 1: Total Rooms -->
        <a href="{{ route('admin.rooms.index') }}" class="bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs flex items-center justify-between hover:border-slate-300 transition">
            <div>
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">Total Rooms</span>
                <span class="text-2xl font-bold text-slate-900 mt-1 block">{{ $totalRoomsCount }} {{ Str::plural('Room', $totalRoomsCount) }}</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-gray-400/10 text-black flex items-center justify-center text-2xl shrink-0">
                <i class="ri-hotel-bed-line"></i>
            </div>
        </a>

        <!-- Card 2: Available Rooms -->
        <a href="{{ route('admin.rooms.index') }}" class="bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs flex items-center justify-between hover:border-emerald-300 transition">
            <div>
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">Available Rooms</span>
                <span class="text-2xl font-bold text-emerald-600 mt-1 block">{{ $availableRoomsCount }} {{ Str::plural('Room', $availableRoomsCount) }}</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-2xl shrink-0">
                <i class="ri-checkbox-circle-line"></i>
            </div>
        </a>

        <!-- Card 3: Booked / Occupied -->
        <a href="{{ route('admin.rooms.index') }}" class="bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs flex items-center justify-between hover:border-blue-300 transition">
            <div>
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">Booked Rooms</span>
                <span class="text-2xl font-bold text-blue-600 mt-1 block">{{ $bookedRoomsCount }} {{ Str::plural('Room', $bookedRoomsCount) }}</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-blue-600/10 text-blue-600 flex items-center justify-center text-2xl shrink-0">
                <i class="ri-user-shared-line"></i>
            </div>
        </a>

        <!-- Card 4: Maintenance / Unavailable -->
        <a href="{{ route('admin.rooms.index') }}" class="bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs flex items-center justify-between hover:border-red-300 transition">
            <div>
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">Unavailable Rooms</span>
                <span class="text-2xl font-bold text-red-500 mt-1 block">{{ $unavailableRoomsCount }} {{ Str::plural('Room', $unavailableRoomsCount) }}</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-red-50 text-red-500 flex items-center justify-center text-2xl shrink-0">
                <i class="ri-tools-line"></i>
            </div>
        </a>
    </div>

    <!-- Unified User Directory & Reservation Status Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-2xs overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h3 class="font-bold text-slate-900 text-sm">Registered Users &amp; Reservation Status</h3>
                <p class="text-xs text-slate-500 mt-0.5">Live user accounts prioritized with linked booking details, stay status, and account controls.</p>
            </div>
            <div class="flex items-center gap-2">
                @if(Route::has('admin.users.index'))
                    <a href="{{ route('admin.users.index') }}" class="px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs transition">
                        Manage All Users
                    </a>
                @endif
                <a href="{{ route('admin.rooms.index') }}" class="px-3.5 py-2 rounded-xl bg-[#06923E] hover:bg-[#057a34] text-white font-semibold text-xs transition">
                    Manage Rooms
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 uppercase tracking-wider font-semibold">
                        <th class="py-3.5 px-5">Code</th>
                        <!-- not all account have to be guest name huhu ka conflic ko di -->
                        <th class="py-3.5 px-5">Name</th> 
                        <!-- Kzyube will add this  -->
                        <th class="py-3.5 px-5">Room Category &amp; No.</th>
                        <th class="py-3.5 px-5">Check-in / Check-out</th>
                        <th class="py-3.5 px-5">Payment / Balance</th>
                        <th class="py-3.5 px-5">Stay Status</th>
                        <th class="py-3.5 px-5">Account Status</th>
                        <th class="py-3.5 px-5 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($userList as $user)
                        @php
                            $fullName = $user->name ?? trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? ''));
                            $reservation = $reservationsByUser->get($user->id)?->first();

                            if ($reservation) {
                                $resId = $reservation->reservation_id ?? $reservation->booking_id ?? $reservation->id;
                                $resCode = $reservation->reservation_code
                                    ?? $reservation->booking_code
                                    ?? ('IH-' . date('Y') . '-' . str_pad($resId, 4, '0', STR_PAD_LEFT));

                                $roomTypeName = $reservation->room->roomType->name ?? 'Unassigned';
                                $roomNo = $reservation->room->room_number ?? 'N/A';

                                $checkIn = \Carbon\Carbon::parse($reservation->check_in_date ?? $reservation->check_in);
                                $checkOut = \Carbon\Carbon::parse($reservation->check_out_date ?? $reservation->check_out);

                                $totalAmount = (float) ($reservation->total_amount ?? $reservation->total_price ?? 0);
                                $amountPaid = (float) ($reservation->amount_paid ?? $reservation->paid_amount ?? 0);
                                $balanceDue = max(0, $totalAmount - $amountPaid);
                                $paidPercent = $totalAmount > 0 ? round(($amountPaid / $totalAmount) * 100) : 0;

                                $stayStatus = strtolower(str_replace(' ', '_', $reservation->status ?? 'pending'));
                            }
                        @endphp

                        <tr class="hover:bg-slate-50/80 transition">
                            <!-- Reservation Code -->
                            <td class="py-3.5 px-5 font-mono">
                                @if($reservation)
                                    <span class="font-bold text-[#06923E]">{{ $resCode }}</span>
                                @else
                                    <span class="text-slate-400">—</span>
                                @endif
                            </td>

                            <!-- User Name, Email & Phone -->
                            <td class="py-3.5 px-5">
                                <span class="font-bold text-slate-900 block">{{ $fullName }}</span>
                                <span class="text-[11px] text-slate-500 block">{{ $user->email }}</span>
                                <span class="text-[10px] font-mono text-slate-400 block">Phone: {{ $user->phone ?? 'N/A' }}</span>
                            </td>

                            <!-- Room Category & No. -->
                            <td class="py-3.5 px-5">
                                @if($reservation)
                                    <span class="font-medium text-slate-800">{{ $roomTypeName }}</span>
                                    <span class="block text-[10px] text-slate-400">Unit {{ $roomNo }}</span>
                                @else
                                    <span class="text-slate-400 italic">Not booked yet</span>
                                @endif
                            </td>

                            <!-- Check-in & Check-out Dates -->
                            <td class="py-3.5 px-5">
                                @if($reservation)
                                    <span class="block">
                                        In: <strong>{{ $checkIn->format('M d, Y') }}</strong>
                                        @if($checkIn->isToday())
                                            <span class="text-[#06923E] font-semibold">(Today)</span>
                                        @endif
                                    </span>
                                    <span class="block text-[11px] text-slate-500 mt-0.5">
                                        Out: {{ $checkOut->format('M d, Y') }}
                                        @if($checkOut->isToday())
                                            <span class="text-amber-600 font-semibold">(Today)</span>
                                        @endif
                                    </span>
                                @else
                                    <span class="text-slate-400">—</span>
                                @endif
                            </td>

                            <!-- Payment / Balance -->
                            <td class="py-3.5 px-5">
                                @if($reservation)
                                    @if($balanceDue <= 0 && $totalAmount > 0)
                                        <span class="text-emerald-700 font-semibold">Fully Settled</span>
                                        <span class="block text-[10px] text-slate-400">
                                            {{ $reservation->payment_method ?? 'Paid' }} (₱{{ number_format($totalAmount, 2) }})
                                        </span>
                                    @else
                                        <span class="text-emerald-700 font-semibold">{{ $paidPercent }}% Paid (₱{{ number_format($amountPaid, 2) }})</span>
                                        <span class="block text-[10px] text-slate-400">Bal: ₱{{ number_format($balanceDue, 2) }} due</span>
                                    @endif
                                @else
                                    <span class="text-slate-400">—</span>
                                @endif
                            </td>

                            <!-- Stay Status -->
                            <td class="py-3.5 px-5">
                                @if(!$reservation)
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-500">
                                        No Booking
                                    </span>
                                @elseif(in_array($stayStatus, ['checked_in', 'active', 'staying']))
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                        Checked In
                                    </span>
                                @elseif(in_array($stayStatus, ['checked_out', 'completed']))
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-700">
                                        Checked Out
                                    </span>
                                @elseif($stayStatus === 'cancelled')
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-rose-100 text-rose-800">
                                        Cancelled
                                    </span>
                                @else
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800">
                                        Pending Check-in
                                    </span>
                                @endif
                            </td>

                            <!-- Account Status (From Users Table) -->
                            <td class="py-3.5 px-5">
                                @if($user->is_active)
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                        Active
                                    </span>
                                @else
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-rose-100 text-rose-800">
                                        Deactivated
                                    </span>
                                @endif
                            </td>

                            <!-- Account Toggle Action -->
                            <td class="py-3.5 px-5 text-right whitespace-nowrap">
                                @if(Route::has('admin.users.toggle-status'))
                                    <form action="{{ route('admin.users.toggle-status', $user->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="font-semibold text-xs {{ $user->is_active ? 'text-rose-600 hover:underline' : 'text-emerald-600 hover:underline' }} cursor-pointer">
                                            {{ $user->is_active ? 'Deactivate' : 'Activate' }}
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-10 text-center text-slate-400">
                                No users registered yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection