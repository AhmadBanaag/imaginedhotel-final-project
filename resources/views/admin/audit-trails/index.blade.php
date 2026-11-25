@extends('layouts.admin')

@section('page-subtitle', 'Audit Trails Log')

@section('content')
<div class="space-y-6" x-data="{
    actionFilter: 'ALL',
    searchQuery: '',
    actions: [
        { key: 'ALL', label: 'All Events' },
        { key: 'ROOM_STATUS_CHANGE', label: 'Room Status' },
        { key: 'PAYMENT_VERIFIED', label: 'Payments' },
        { key: 'GUEST_CHECK_IN', label: 'Check-ins' },
        { key: 'GUEST_CHECK_OUT', label: 'Check-outs' },
        { key: 'CANCELLATION', label: 'Cancellations' }
    ],
    logs: [
        { timestamp: '{{ date('Y-m-d H:i:s') }}', actor: 'Admin (Ahmad Banaag)', action: 'ROOM_STATUS_CHANGE', badge: 'bg-blue-100 text-blue-800', details: 'Toggled Room 105 status to Unavailable (Housekeeping / Maintenance)', ip: '127.0.0.1' },
        { timestamp: '{{ date('Y-m-d H:i:s', strtotime('-18 mins')) }}', actor: 'Receptionist (Carl James Ayag)', action: 'PAYMENT_VERIFIED', badge: 'bg-emerald-100 text-emerald-800', details: 'Approved GCash QR Reference REF-849102 (₱2,999.00) for IH-2026-8492', ip: '127.0.0.1' },
        { timestamp: '{{ date('Y-m-d H:i:s', strtotime('-42 mins')) }}', actor: 'Receptionist (Kzyube Napoles)', action: 'GUEST_CHECK_IN', badge: 'bg-purple-100 text-purple-800', details: 'Checked in guest Maria Santos into Family Room 301 (IH-2026-7911)', ip: '127.0.0.1' },
        { timestamp: '{{ date('Y-m-d H:i:s', strtotime('-2 hours')) }}', actor: 'Receptionist (Carl James Ayag)', action: 'GUEST_CHECK_OUT', badge: 'bg-slate-200 text-slate-800', details: 'Checked out guest Elena Mendoza from Superior Room 401 (IH-2026-8450)', ip: '127.0.0.1' },
        { timestamp: '{{ date('Y-m-d H:i:s', strtotime('-5 hours')) }}', actor: 'Admin (Ahmad Banaag)', action: 'CANCELLATION', badge: 'bg-rose-100 text-rose-800', details: 'Processed cancellation for IH-2026-8398; retained 20% fee (₱200) and refunded ₱800', ip: '127.0.0.1' },
        { timestamp: '{{ date('Y-m-d H:i:s', strtotime('-1 day')) }}', actor: 'Receptionist (Kzyube Napoles)', action: 'ROOM_STATUS_CHANGE', badge: 'bg-blue-100 text-blue-800', details: 'Marked Room 206 as Unavailable for AC servicing', ip: '127.0.0.1' }
    ],
    get filteredLogs() {
        const q = this.searchQuery.trim().toLowerCase();
        return this.logs.filter(log => {
            const matchAction = this.actionFilter === 'ALL' || log.action === this.actionFilter;
            const matchSearch = !q || log.actor.toLowerCase().includes(q) || log.details.toLowerCase().includes(q) || log.action.toLowerCase().includes(q);
            return matchAction && matchSearch;
        });
    }
}">
    <!-- Filter & Search Bar -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs flex flex-col lg:flex-row lg:items-center justify-between gap-4">
        <div class="flex flex-wrap gap-1.5 text-xs">
            <template x-for="act in actions" :key="act.key">
                <button @click="actionFilter = act.key"
                    :class="actionFilter === act.key ? 'bg-slate-900 text-white font-bold' : 'bg-slate-100 text-slate-700 hover:bg-slate-200'"
                    class="px-3 py-1.5 rounded-lg transition"
                    x-text="act.label">
                </button>
            </template>
        </div>
        <div class="relative w-full lg:w-72">
            <i class="ri-search-line absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
            <input type="text" x-model="searchQuery" placeholder="Search staff name or log details..." class="w-full pl-8 pr-3 py-1.5 text-xs rounded-xl border-slate-200 focus:ring-[#EDC92C] focus:border-[#EDC92C]">
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-2xs overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex justify-between items-center">
            <div>
                <h3 class="font-bold text-slate-900 text-sm">System Audit Trails</h3>
                <p class="text-xs text-slate-500 mt-0.5">Chronological tracking of staff actions, room availability updates, and payment approvals.</p>
            </div>
            <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-[#06923E]">
                <span x-text="filteredLogs.length"></span> Events Shown
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
                        <th class="py-3.5 px-5 text-right">IP Address</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700 font-mono">
                    <template x-for="(log, index) in filteredLogs" :key="index">
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="py-3 px-5 text-slate-500 whitespace-nowrap" x-text="log.timestamp"></td>
                            <td class="py-3 px-5 font-sans font-semibold text-slate-900" x-text="log.actor"></td>
                            <td class="py-3 px-5 font-sans">
                                <span :class="log.badge" class="px-2 py-0.5 rounded-sm font-semibold text-[10px]" x-text="log.action"></span>
                            </td>
                            <td class="py-3 px-5 font-sans" x-text="log.details"></td>
                            <td class="py-3 px-5 text-right text-slate-400" x-text="log.ip"></td>
                        </tr>
                    </template>
                    <tr x-show="filteredLogs.length === 0">
                        <td colspan="5" class="py-10 text-center font-sans text-slate-400">No audit trail events match your filter.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
