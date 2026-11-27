@extends('layouts.hotel')

@section('rooms')
@include('components.navbar2')
<section class="pt-34">
    @include('components.search-widget')
</section>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-9 pb-1">
    <section class="pb-10 pt-1 max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
        <!-- Header & Reset Link -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight">Available Rooms</h1>
                <p class="text-slate-500 text-sm mt-1">
                    @if ($hasActiveFilters && !$searchError)
                        Showing {{ $categories->sum('available_units') }} available {{ Str::plural('unit', $categories->sum('available_units')) }}
                        for {{ $nights }} {{ Str::plural('night', $nights) }}
                        ({{ \Carbon\CarbonImmutable::parse($filters['check_in'])->format('M d') }} – {{ \Carbon\CarbonImmutable::parse($filters['check_out'])->format('M d, Y') }}).
                    @else
                        Select from our best rooms in ImaginedHotel.
                    @endif
                </p>
            </div>

            @if ($hasActiveFilters)
                <a href="{{ route('rooms.index') }}" class="text-xs font-semibold text-[#06923E] hover:underline">
                    Clear search filters &times;
                </a>
            @endif
        </div>

        @if ($searchError)
            <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-semibold">
                {{ $searchError }}
            </div>
        @endif

        <!-- Room Results Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse ($categories as $category)
                <div class="bg-white rounded-2xl {{ $category['is_vip'] ? 'border-2 border-amber-300 shadow-xs' : 'border border-slate-200 shadow-2xs' }} overflow-hidden hover:shadow-md transition flex flex-col justify-between">
                    <div>
                        <div class="h-44 {{ $category['image_class'] }} bg-cover bg-center relative p-4 flex items-center justify-center text-white">
                            <span class="absolute top-3 left-3 px-2 py-0.5 rounded-full text-[10px] font-bold bg-[#06923E] text-white">
                                {{ $category['available_units'] }} {{ Str::plural('Unit', $category['available_units']) }} Available
                            </span>
                            <span class="absolute top-3 right-3 px-2.5 py-1 rounded-full text-xs font-bold {{ $category['is_vip'] ? 'bg-[#EDC92C]' : 'bg-[#06923E]' }} text-white">
                                ₱{{ number_format($category['rate'], 0) }}<span class="text-[10px] font-normal">/night</span>
                            </span>
                        </div>
                        <div class="p-5">
                            <h3 class="text-lg font-bold text-slate-900">{{ $category['name'] }}</h3>
                            <p class="text-xs text-slate-500 mt-1 mb-3">{{ $category['description'] }}</p>
                            <div class="flex flex-wrap gap-1.5 mb-4 text-[11px]">
                                @foreach ($category['amenities'] as $amenity)
                                    <span class="px-2 py-0.5 {{ $category['is_vip'] && $loop->first ? 'bg-amber-50 text-amber-700 font-medium' : 'bg-slate-100 text-slate-600' }} rounded-sm">
                                        {{ $amenity }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="p-5 pt-0">
                        <a href="{{ route('reservations.create', ['room_type' => $category['slug'], 'check_in' => $filters['check_in'], 'check_out' => $filters['check_out']]) }}"
                           class="block w-full text-center py-2.5 rounded-xl {{ $category['is_vip'] ? 'bg-[#EDC92C] hover:bg-amber-600 font-bold' : 'bg-[#06923E] hover:bg-[#EDC92C] font-semibold' }} text-white text-xs transition">
                            Reserve for ₱{{ number_format($category['rate'], 0) }} &rarr;
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white rounded-2xl border border-slate-200 p-10 text-center text-slate-500 text-sm font-semibold">
                    No room available
                </div>
            @endforelse
        </div>
    </section>
</div>
@endsection