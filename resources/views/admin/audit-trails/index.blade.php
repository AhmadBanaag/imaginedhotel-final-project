@extends('layouts.admin')

@section('page-title', 'Security & Audit Trails Log')
@section('page-subtitle', 'Chronological tracking of staff activities, room availability changes, and payment verification events')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-2xl border border-slate-200 shadow-2xs overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex justify-between items-center">
            <div>
                <h3 class="font-bold text-slate-900 text-sm">System Audit Trails</h3>
                <p class="text-xs text-slate-500 mt-0.5">Capturing user IDs, action summaries, and timestamp verification.</p>
            </div>
            <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-700">
                Live Audit Active
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
                    <tr class="hover:bg-slate-50/80 transition">
                        <td class="py-3 px-5 text-slate-500">{{ date('Y-m-d H:i:s') }}</td>
                        <td class="py-3 px-5 font-sans font-semibold text-slate-900">Admin (Ahmad Banaag)</td>
                        <td class="py-3 px-5 font-sans">
                            <span class="px-2 py-0.5 rounded-sm bg-blue-100 text-blue-800 font-semibold text-[10px]">ROOM_STATUS_CHANGE</span>
                        </td>
                        <td class="py-3 px-5 font-sans">Toggled Room 105 status to Unavailable (Maintenance)</td>
                        <td class="py-3 px-5 text-right text-slate-400">127.0.0.1</td>
                    </tr>
                    <tr class="hover:bg-slate-50/80 transition">
                        <td class="py-3 px-5 text-slate-500">{{ date('Y-m-d H:i:s', strtotime('-18 mins')) }}</td>
                        <td class="py-3 px-5 font-sans font-semibold text-slate-900">Receptionist (Carl Ayag)</td>
                        <td class="py-3 px-5 font-sans">
                            <span class="px-2 py-0.5 rounded-sm bg-emerald-100 text-emerald-800 font-semibold text-[10px]">PAYMENT_VERIFIED</span>
                        </td>
                        <td class="py-3 px-5 font-sans">Approved GCash QR Reference REF-849102 (₱2,999.00)</td>
                        <td class="py-3 px-5 text-right text-slate-400">127.0.0.1</td>
                    </tr>
                    <tr class="hover:bg-slate-50/80 transition">
                        <td class="py-3 px-5 text-slate-500">{{ date('Y-m-d H:i:s', strtotime('-42 mins')) }}</td>
                        <td class="py-3 px-5 font-sans font-semibold text-slate-900">Receptionist (Kzyube Napoles)</td>
                        <td class="py-3 px-5 font-sans">
                            <span class="px-2 py-0.5 rounded-sm bg-purple-100 text-purple-800 font-semibold text-[10px]">GUEST_CHECK_IN</span>
                        </td>
                        <td class="py-3 px-5 font-sans">Checked in guest Maria Santos into Room 301 (IH-2026-7911)</td>
                        <td class="py-3 px-5 text-right text-slate-400">127.0.0.1</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
