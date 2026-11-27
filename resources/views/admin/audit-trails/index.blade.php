@extends('layouts.admin')

@section('page-subtitle', 'Audit Trails Log')

@section('content')
@php
    $actions = [
        'ALL'                => ['label' => 'All Events',   'color' => 'bg-slate-900 text-white'],
        'ROOM_STATUS_CHANGE' => ['label' => 'Room Status',  'color' => 'bg-blue-100 text-blue-800'],
        'PAYMENT_VERIFIED'   => ['label' => 'Payments',     'color' => 'bg-emerald-100 text-emerald-800'],
        'GUEST_CHECK_IN'     => ['label' => 'Check-ins',    'color' => 'bg-purple-100 text-purple-800'],
        'GUEST_CHECK_OUT'    => ['label' => 'Check-outs',   'color' => 'bg-[#EDC92C] text-white'],
        'CANCELLATION'       => ['label' => 'Cancellations','color' => 'bg-rose-100 text-rose-800'],
    ];
@endphp

<div class="space-y-6">
    <!-- Filter & Search Bar -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs flex flex-col lg:flex-row lg:items-center justify-between gap-4">
        <div class="flex flex-wrap gap-1.5 text-xs">
            @foreach ($actions as $key => $act)
                <a href="{{ route('admin.audit-trails.index', array_filter(['action_type' => $key, 'q' => $search])) }}"
                   class="px-3 py-1.5 rounded-lg transition {{ $actionType === $key ? $act['color'] . ' font-bold' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                    {{ $act['label'] }}
                </a>
            @endforeach
        </div>

        <form action="{{ route('admin.audit-trails.index') }}" method="GET" class="flex items-center gap-2 w-full lg:w-80">
            <input type="hidden" name="action_type" value="{{ $actionType }}">
            <div class="relative flex-1">
                <i class="ri-search-line absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                <input type="text" name="q" value="{{ $search }}"
                    placeholder="Search staff name or log details..."
                    class="w-full pl-8 pr-3 py-1.5 text-xs rounded-xl border-slate-200 focus:ring-[#EDC92C] focus:border-[#EDC92C]">
            </div>
            <button type="submit" class="px-3 py-1.5 rounded-xl bg-slate-900 text-white text-xs font-semibold hover:bg-slate-800 transition">
                Search
            </button>
        </form>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-2xs overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex justify-between items-center">
            <div>
                <h3 class="font-bold text-slate-900 text-sm">Audit Trails Log</h3>
            </div>
            <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-[#06923E]">
                {{ $logs->total() }} {{ Str::plural('Event', $logs->total()) }} Found
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 uppercase font-semibold">
                        <th class="py-3.5 px-5">Timestamp</th>
                        <th class="py-3.5 px-5">Officer / User</th>
                        <th class="py-3.5 px-5">Action Performed</th>
                        <th class="py-3.5 px-5">Details &amp; Affected Record</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700 font-mono">
                    @forelse ($logs as $log)
                        @php
                            $badgeClass = $actions[$log->action_type]['color'] ?? 'bg-slate-100 text-slate-700';
                        @endphp
                        <tr class="hover:bg-slate-50/80 transition align-top">
                            <td class="py-3 px-5 text-slate-500 whitespace-nowrap">
                                {{ $log->created_at?->format('Y-m-d H:i:s') }}
                            </td>
                            <td class="py-3 px-5 font-sans font-semibold text-slate-900">
                                {{ $log->actor_name }}
                            </td>
                            <td class="py-3 px-5 font-sans">
                                <span class="{{ $badgeClass }} px-2 py-0.5 rounded-sm font-semibold text-[10px]">
                                    {{ $log->action_type }}
                                </span>
                            </td>
                            <td class="py-3 px-5 font-sans">
                                <p>{{ $log->details }}</p>

                                @if (!empty($log->old_values) || !empty($log->new_values))
                                    <details class="mt-1.5 text-[11px] text-slate-500">
                                        <summary class="cursor-pointer font-semibold text-slate-600 hover:text-slate-900">
                                            View value changes
                                        </summary>
                                        <div class="mt-1.5 grid grid-cols-1 sm:grid-cols-2 gap-2 font-mono bg-slate-50 p-2.5 rounded-lg border border-slate-200">
                                            <div>
                                                <span class="block font-sans font-semibold text-slate-400 uppercase text-[10px]">Old Values</span>
                                                <pre class="whitespace-pre-wrap">{{ json_encode($log->old_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                            </div>
                                            <div>
                                                <span class="block font-sans font-semibold text-slate-400 uppercase text-[10px]">New Values</span>
                                                <pre class="whitespace-pre-wrap">{{ json_encode($log->new_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                            </div>
                                        </div>
                                    </details>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-10 text-center font-sans text-slate-400">
                                No audit trail events match your filter.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($logs->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $logs->links() }}
            </div>
        @endif
    </div>
</div>
@endsection