@extends('layouts.admin')
<!-- Replace the dummy with the data from the database. -->
@section('page-title', 'User & Staff Account Management')
@section('page-subtitle', 'Manage registered guest profiles and admin permissions')

@section('content')
<div class="space-y-6">
    <!-- Success Alert -->
    @if(session('success'))
        <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl border border-slate-200 shadow-2xs overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h3 class="font-bold text-slate-900 text-sm">System User Directory</h3>
                <p class="text-xs text-slate-500 mt-0.5">Control account activation and role authorizations.</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 uppercase font-semibold">
                        <th class="py-3.5 px-5">User</th>
                        <th class="py-3.5 px-5">Email Address</th>
                        <th class="py-3.5 px-5">Phone</th>
                        <th class="py-3.5 px-5">Account Status</th>
                        <th class="py-3.5 px-5 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($users as $user)
                    <tr class="hover:bg-slate-50/80 transition">
                        <td class="py-3.5 px-5">
                            <span class="font-bold text-slate-900 block">{{ $user->name ?? ($user->first_name . ' ' . $user->last_name) }}</span>
                        </td>
                        <td class="py-3.5 px-5">{{ $user->email }}</td>
                        <td class="py-3.5 px-5 font-mono">{{ $user->phone ?? 'N/A' }}</td>
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
                        <td class="py-3.5 px-5 text-right space-x-2">
                            <!-- Toggle Status Form -->
                            <form action="{{ route('admin.users.toggle-status', $user->id) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="font-semibold text-xs {{ $user->is_active ? 'text-rose-600 hover:underline' : 'text-emerald-600 hover:underline' }} cursor-pointer">
                                    {{ $user->is_active ? 'Deactivate' : 'Activate' }}
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-8 text-center text-slate-400">
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