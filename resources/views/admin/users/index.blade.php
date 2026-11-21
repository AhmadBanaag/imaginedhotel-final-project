@extends('layouts.admin')

@section('page-title', 'User & Staff Account Management')
@section('page-subtitle', 'Manage registered guest profiles, receptionist credentials, and admin permissions')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h3 class="font-bold text-slate-900 text-sm">System User Directory</h3>
                <p class="text-xs text-slate-500 mt-0.5">Control account activation and role authorizations (Admin, Receptionist, Guest).</p>
            </div>
            <button onclick="alert('User invitation dialog opened.')" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-xs rounded-xl shadow-xs transition inline-flex items-center gap-1.5">
                <i class="ri-user-add-line"></i> Add New Staff Account
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 uppercase font-semibold">
                        <th class="py-3.5 px-5">User</th>
                        <th class="py-3.5 px-5">Email Address</th>
                        <th class="py-3.5 px-5">Phone Number</th>
                        <th class="py-3.5 px-5">System Role</th>
                        <th class="py-3.5 px-5">Account Status</th>
                        <th class="py-3.5 px-5 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    <!-- User 1: Admin -->
                    <tr class="hover:bg-slate-50/80 transition">
                        <td class="py-3.5 px-5">
                            <span class="font-bold text-slate-900 block">Ahmad Banaag</span>
                            <span class="text-[10px] text-slate-400">Lead Project Developer</span>
                        </td>
                        <td class="py-3.5 px-5">admin@imaginedhotel.com</td>
                        <td class="py-3.5 px-5 font-mono">0917-111-2222</td>
                        <td class="py-3.5 px-5">
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-purple-100 text-purple-800">
                                Administrator
                            </span>
                        </td>
                        <td class="py-3.5 px-5">
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                Active
                            </span>
                        </td>
                        <td class="py-3.5 px-5 text-right space-x-2">
                            <button onclick="alert('Edit permissions')" class="text-indigo-600 hover:underline font-semibold">Edit Role</button>
                        </td>
                    </tr>

                    <!-- User 2: Receptionist -->
                    <tr class="hover:bg-slate-50/80 transition">
                        <td class="py-3.5 px-5">
                            <span class="font-bold text-slate-900 block">Carl James Ayag</span>
                            <span class="text-[10px] text-slate-400">Front Desk Officer</span>
                        </td>
                        <td class="py-3.5 px-5">receptionist@imaginedhotel.com</td>
                        <td class="py-3.5 px-5 font-mono">0918-333-4444</td>
                        <td class="py-3.5 px-5">
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-indigo-100 text-indigo-800">
                                Receptionist
                            </span>
                        </td>
                        <td class="py-3.5 px-5">
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                Active
                            </span>
                        </td>
                        <td class="py-3.5 px-5 text-right space-x-2">
                            <button onclick="alert('Edit permissions')" class="text-indigo-600 hover:underline font-semibold">Edit Role</button>
                        </td>
                    </tr>

                    <!-- User 3: Guest -->
                    <tr class="hover:bg-slate-50/80 transition">
                        <td class="py-3.5 px-5">
                            <span class="font-bold text-slate-900 block">Kzyube Napoles</span>
                            <span class="text-[10px] text-slate-400">Registered Guest</span>
                        </td>
                        <td class="py-3.5 px-5">guest@example.com</td>
                        <td class="py-3.5 px-5 font-mono">0919-555-6666</td>
                        <td class="py-3.5 px-5">
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-700">
                                Guest
                            </span>
                        </td>
                        <td class="py-3.5 px-5">
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                Active
                            </span>
                        </td>
                        <td class="py-3.5 px-5 text-right space-x-2">
                            <button onclick="alert('Account toggled')" class="text-slate-400 hover:text-rose-600 font-semibold">Deactivate</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
