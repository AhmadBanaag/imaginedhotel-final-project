@extends('layouts.admin')

@section('page-title', 'User & Staff Account Management')
@section('page-subtitle', 'Manage Users & Roles')

@section('content')
@php
    $roleBadge = fn (?string $roleName) => match (strtolower($roleName ?? '')) {
        'admin' => 'bg-purple-100 text-purple-800',
        'account_user' => 'bg-blue-100 text-blue-800',
        'guest' => 'bg-emerald-50 text-emerald-700',
        default => 'bg-slate-100 text-slate-600',
    };
@endphp

<div class="space-y-6" x-data="{
    showAddModal: {{ $errors->hasAny(['name', 'email', 'phone', 'password']) ? 'true' : 'false' }},
    editingUser: null,
    editRoleId: ''
}">
    @if (session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-900 rounded-2xl p-4 text-xs flex items-center justify-between">
            <div class="flex items-center gap-2">
                <i class="ri-checkbox-circle-line text-lg text-[#06923E]"></i>
                <span class="font-semibold">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if ($errors->any() && !$errors->hasAny(['name', 'email', 'phone', 'password']))
        <div class="bg-rose-50 border border-rose-200 text-rose-800 rounded-2xl p-4 text-xs font-semibold">
            {{ $errors->first() }}
        </div>
    @endif

    <!-- Filter & Action Bar -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs flex flex-col lg:flex-row lg:items-center justify-between gap-4">
        <div class="flex flex-wrap gap-1.5 text-xs">
            <a href="{{ route('admin.users.index', array_filter(['q' => $search])) }}"
               class="px-3 py-1.5 rounded-lg transition {{ blank($roleFilter) ? 'bg-slate-900 text-white font-bold' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                All Users
            </a>
            @foreach ($roles as $role)
                <a href="{{ route('admin.users.index', array_filter(['role_id' => $role->role_id, 'q' => $search])) }}"
                   class="px-3 py-1.5 rounded-lg transition {{ (string) $roleFilter === (string) $role->role_id ? 'bg-slate-900 text-white font-bold' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                    {{ ucwords(str_replace('_', ' ', $role->role_name)) }}
                </a>
            @endforeach
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <form action="{{ route('admin.users.index') }}" method="GET" class="flex items-center gap-2">
                @if (filled($roleFilter))
                    <input type="hidden" name="role_id" value="{{ $roleFilter }}">
                @endif
                <div class="relative">
                    <i class="ri-search-line absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    <input type="text" name="q" value="{{ $search }}" placeholder="Search name, email, phone..."
                           class="pl-8 pr-3 py-1.5 text-xs rounded-xl border-slate-200 focus:ring-[#EDC92C] focus:border-[#EDC92C]">
                </div>
                <button type="submit" class="px-3 py-1.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-semibold transition cursor-pointer">
                    Search
                </button>
            </form>

            <button type="button" @click="showAddModal = true"
                    class="px-4 py-2 bg-[#06923E] hover:bg-[#057a34] text-white font-semibold text-xs rounded-xl shadow-2xs transition inline-flex items-center gap-1.5 cursor-pointer">
                <i class="ri-user-add-line"></i> Add Staff Account
            </button>
        </div>
    </div>

    <!-- Directory Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-2xs overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="font-bold text-slate-900 text-sm">System User Directory</h3>
                <p class="text-xs text-slate-500 mt-0.5">Control account creation, role assignments, and account status.</p>
            </div>
            <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-[#06923E]">
                {{ $users->count() }} {{ Str::plural('Account', $users->count()) }}
            </span>
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
                    @forelse ($users as $user)
                        @php
                            $displayName = trim($user->name ?: ($user->first_name . ' ' . $user->last_name));
                            $roleLabel = $user->role?->role_name
                                ? ucwords(str_replace('_', ' ', $user->role->role_name))
                                : 'Unassigned';
                        @endphp
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="py-3.5 px-5">
                                <span class="font-bold text-slate-900 block">{{ $displayName }}</span>
                            </td>
                            <td class="py-3.5 px-5">{{ $user->email }}</td>
                            <td class="py-3.5 px-5 font-mono">{{ $user->phone ?? 'N/A' }}</td>
                            <td class="py-3.5 px-5">
                                <span class="{{ $roleBadge($user->role?->role_name) }} px-2.5 py-0.5 rounded-full text-[10px] font-bold">
                                    {{ $roleLabel }}
                                </span>
                            </td>
                            <td class="py-3.5 px-5">
                                @if ($user->is_active)
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                        Active
                                    </span>
                                @else
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-rose-100 text-rose-700">
                                        Deactivated
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-5 text-right space-x-3 whitespace-nowrap">
                                @if ($roles->isNotEmpty())
                                    <button type="button"
                                            @click="editingUser = { id: {{ $user->id }}, name: @js($displayName) }; editRoleId = '{{ $user->role_id ?? $roles->first()->role_id }}'"
                                            class="text-[#06923E] hover:underline font-semibold cursor-pointer">
                                        Edit Role
                                    </button>
                                @endif

                                <form action="{{ route('admin.users.toggle-status', $user->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                            class="{{ $user->is_active ? 'text-slate-500 hover:text-rose-600' : 'text-emerald-700 hover:underline' }} font-semibold cursor-pointer">
                                        {{ $user->is_active ? 'Deactivate' : 'Activate' }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-10 text-center text-slate-400">
                                No user accounts match your filter.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add Staff / User Modal -->
    <div x-show="showAddModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 p-4">
        <div @click.outside="showAddModal = false" class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <h3 class="text-base font-bold text-slate-900">Add New Staff Account</h3>
                <button type="button" @click="showAddModal = false" class="text-slate-400 hover:text-slate-700 cursor-pointer"><i class="ri-close-line text-xl"></i></button>
            </div>

            @if ($errors->hasAny(['name', 'email', 'phone', 'role_id', 'password']))
                <div class="p-3 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs">
                    <ul class="list-disc list-inside space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-3 text-xs">
                @csrf
                <div>
                    <label class="block font-semibold text-slate-700 mb-1">Full Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" required placeholder="e.g. Alex Cruz"
                           class="w-full text-sm rounded-xl border-slate-200 focus:ring-[#EDC92C] focus:border-[#EDC92C]">
                </div>
                <div>
                    <label class="block font-semibold text-slate-700 mb-1">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" required placeholder="staff@imaginedhotel.com"
                           class="w-full text-sm rounded-xl border-slate-200 focus:ring-[#EDC92C] focus:border-[#EDC92C]">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Phone Number</label>
                        <input type="tel" name="phone" value="{{ old('phone') }}" placeholder="0917-000-0000"
                               class="w-full text-sm rounded-xl border-slate-200 focus:ring-[#EDC92C] focus:border-[#EDC92C]">
                    </div>
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Role</label>
                        <select name="role_id" class="w-full text-sm rounded-xl border-slate-200 focus:ring-[#EDC92C] focus:border-[#EDC92C]">
                            <option value="">Unassigned</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->role_id }}" @selected((string) old('role_id') === (string) $role->role_id)>
                                    {{ ucwords(str_replace('_', ' ', $role->role_name)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Password</label>
                        <input type="password" name="password" required minlength="8" placeholder="Min. 8 chars"
                               class="w-full text-sm rounded-xl border-slate-200 focus:ring-[#EDC92C] focus:border-[#EDC92C]">
                    </div>
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Confirm Password</label>
                        <input type="password" name="password_confirmation" required minlength="8" placeholder="Repeat password"
                               class="w-full text-sm rounded-xl border-slate-200 focus:ring-[#EDC92C] focus:border-[#EDC92C]">
                    </div>
                </div>
                <div class="flex gap-2 pt-3">
                    <button type="button" @click="showAddModal = false" class="flex-1 py-2.5 rounded-xl border border-slate-200 text-slate-700 font-semibold hover:bg-slate-50 cursor-pointer">Cancel</button>
                    <button type="submit" class="flex-1 py-2.5 rounded-xl bg-[#06923E] hover:bg-[#057a34] text-white font-bold cursor-pointer">Create Account</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Role Modal -->
    <div x-show="editingUser !== null" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 p-4">
        <div @click.outside="editingUser = null" class="bg-white rounded-2xl max-w-sm w-full p-6 shadow-2xl space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <h3 class="text-base font-bold text-slate-900">Edit Role</h3>
                <button type="button" @click="editingUser = null" class="text-slate-400 hover:text-slate-700 cursor-pointer"><i class="ri-close-line text-xl"></i></button>
            </div>
            <form :action="'{{ url('/admin/users') }}/' + editingUser?.id + '/role'" method="POST" class="space-y-4">
                @csrf
                @method('PATCH')
                <div class="text-xs space-y-3">
                    <p class="text-slate-600">Assign system role for <strong class="text-slate-900" x-text="editingUser?.name"></strong>:</p>
                    <select name="role_id" x-model="editRoleId" required class="w-full text-sm rounded-xl border-slate-200 focus:ring-[#EDC92C] focus:border-[#EDC92C]">
                        @foreach ($roles as $role)
                            <option value="{{ $role->role_id }}">
                                {{ ucwords(str_replace('_', ' ', $role->role_name)) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="flex gap-2 pt-2">
                    <button type="button" @click="editingUser = null" class="flex-1 py-2.5 rounded-xl border border-slate-200 text-slate-700 text-xs font-semibold hover:bg-slate-50 cursor-pointer">Cancel</button>
                    <button type="submit" class="flex-1 py-2.5 rounded-xl bg-[#06923E] hover:bg-[#057a34] text-white text-xs font-bold cursor-pointer">Save Role</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
