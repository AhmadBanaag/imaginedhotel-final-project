@extends('layouts.admin')

@section('page-subtitle', 'Manage Users & Roles')

@section('content')
<div class="space-y-6" x-data="{
    roleFilter: 'ALL',
    searchQuery: '',
    showAddModal: false,
    editingUser: null,
    editRoleValue: 'Administrator',
    newName: '',
    newEmail: '',
    newPhone: '',
    newTitle: 'Hotel Administrator',
    newRole: 'Administrator',
    toastMessage: '',
    users: [
        { id: 1, name: 'Ahmad Banaag', title: 'Lead Project Developer', email: 'admin@imaginedhotel.com', phone: '0917-111-2222', role: 'Administrator', active: true },
        { id: 2, name: 'Carl James Ayag', title: 'Hotel Administrator', email: 'carl@imaginedhotel.com', phone: '0918-333-4444', role: 'Administrator', active: true },
        { id: 3, name: 'Kzyube Napoles', title: 'Night Shift Admin', email: 'kzyube@imaginedhotel.com', phone: '0919-555-6666', role: 'Administrator', active: true },
        { id: 4, name: 'Juan Dela Cruz', title: 'Registered Guest', email: 'guest@example.com', phone: '0917-123-4567', role: 'Guest', active: true },
        { id: 5, name: 'Maria Santos', title: 'Registered Guest', email: 'maria.santos@example.com', phone: '0918-987-6543', role: 'Guest', active: true }
    ],
    get filteredUsers() {
        const q = this.searchQuery.trim().toLowerCase();
        return this.users.filter(u => {
            const matchRole = this.roleFilter === 'ALL' || u.role === this.roleFilter;
            const matchSearch = !q || u.name.toLowerCase().includes(q) || u.email.toLowerCase().includes(q) || u.phone.toLowerCase().includes(q);
            return matchRole && matchSearch;
        });
    },
    roleBadge(role) {
        if (role === 'Administrator') return 'bg-purple-100 text-purple-800';
        return 'bg-slate-100 text-slate-700';
    },
    openRoleModal(user) {
        this.editingUser = user;
        this.editRoleValue = user.role;
    },
    saveRole() {
        if (!this.editingUser) return;
        this.editingUser.role = this.editRoleValue;
        this.toastMessage = this.editingUser.name + ' role updated to ' + this.editRoleValue + '.';
        this.editingUser = null;
    },
    addUser() {
        this.users.unshift({
            id: Date.now(),
            name: this.newName,
            title: this.newTitle || 'Staff Member',
            email: this.newEmail,
            phone: this.newPhone || '0917-000-0000',
            role: this.newRole,
            active: true
        });
        this.toastMessage = 'Added ' + this.newName + ' (' + this.newRole + ') to the directory.';
        this.newName = '';
        this.newEmail = '';
        this.newPhone = '';
        this.newRole = 'Administrator';
        this.showAddModal = false;
    },
    toggleActive(user) {
        user.active = !user.active;
        this.toastMessage = user.name + ' account ' + (user.active ? 'activated' : 'deactivated') + '.';
    }
}">
    <div x-show="toastMessage" x-cloak class="bg-emerald-50 border border-emerald-200 text-emerald-900 rounded-2xl p-4 text-xs flex items-center justify-between">
        <div class="flex items-center gap-2">
            <i class="ri-checkbox-circle-line text-lg text-[#06923E]"></i>
            <span class="font-semibold" x-text="toastMessage"></span>
        </div>
        <button type="button" @click="toastMessage = ''" class="text-emerald-700 hover:text-emerald-950"><i class="ri-close-line text-base"></i></button>
    </div>

    <!-- Filter & Action Bar -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs flex flex-col lg:flex-row lg:items-center justify-between gap-4">
        <div class="flex flex-wrap gap-1.5 text-xs">
            <button @click="roleFilter = 'ALL'" :class="roleFilter === 'ALL' ? 'bg-slate-900 text-white font-bold' : 'bg-slate-100 text-slate-700'" class="px-3 py-1.5 rounded-lg transition">All Users</button>
            <button @click="roleFilter = 'Administrator'" :class="roleFilter === 'Administrator' ? 'bg-slate-900 text-white font-bold' : 'bg-slate-100 text-slate-700'" class="px-3 py-1.5 rounded-lg transition">Administrator</button>
            <button @click="roleFilter = 'Guest'" :class="roleFilter === 'Guest' ? 'bg-slate-900 text-white font-bold' : 'bg-slate-100 text-slate-700'" class="px-3 py-1.5 rounded-lg transition">Guest</button>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            <div class="relative">
                <i class="ri-search-line absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                <input type="text" x-model="searchQuery" placeholder="Search name, email, phone..." class="pl-8 pr-3 py-1.5 text-xs rounded-xl border-slate-200 focus:ring-[#EDC92C] focus:border-[#EDC92C]">
            </div>
            <button type="button" @click="showAddModal = true" class="px-4 py-2 bg-[#06923E] hover:bg-[#057a34] text-white font-semibold text-xs rounded-xl shadow-2xs transition inline-flex items-center gap-1.5">
                <i class="ri-user-add-line"></i> Add Staff Account
            </button>
        </div>
    </div>

    <!-- Directory Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-2xs overflow-hidden">
        <div class="p-5 border-b border-slate-100">
            <h3 class="font-bold text-slate-900 text-sm">System User &amp; Staff</h3>
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
                    <template x-for="user in filteredUsers" :key="user.id">
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="py-3.5 px-5">
                                <span class="font-bold text-slate-900 block" x-text="user.name"></span>
                                <span class="text-[10px] text-slate-400" x-text="user.title"></span>
                            </td>
                            <td class="py-3.5 px-5" x-text="user.email"></td>
                            <td class="py-3.5 px-5 font-mono" x-text="user.phone"></td>
                            <td class="py-3.5 px-5">
                                <span :class="roleBadge(user.role)" class="px-2.5 py-0.5 rounded-full text-[10px] font-bold" x-text="user.role"></span>
                            </td>
                            <td class="py-3.5 px-5">
                                <span :class="user.active ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-700'"
                                    class="px-2.5 py-0.5 rounded-full text-[10px] font-bold"
                                    x-text="user.active ? 'Active' : 'Inactive'"></span>
                            </td>
                            <td class="py-3.5 px-5 text-right space-x-3 whitespace-nowrap">
                                <button type="button" @click="openRoleModal(user)" class="text-[#06923E] hover:underline font-semibold">Edit Role</button>
                                <button type="button" @click="toggleActive(user)"
                                    :class="user.active ? 'text-slate-500 hover:text-rose-600' : 'text-emerald-700 hover:underline'"
                                    class="font-semibold"
                                    x-text="user.active ? 'Deactivate' : 'Activate'"></button>
                            </td>
                        </tr>
                    </template>
                    <tr x-show="filteredUsers.length === 0">
                        <td colspan="6" class="py-10 text-center text-slate-400">No user accounts match your filter.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add Staff Modal -->
    <div x-show="showAddModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 p-4">
        <div @click.outside="showAddModal = false" class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <h3 class="text-base font-bold text-slate-900">Add New Staff Account</h3>
                <button type="button" @click="showAddModal = false" class="text-slate-400 hover:text-slate-700"><i class="ri-close-line text-xl"></i></button>
            </div>
            <form @submit.prevent="addUser()" class="space-y-3 text-xs">
                <div>
                    <label class="block font-semibold text-slate-700 mb-1">Full Name</label>
                    <input type="text" x-model="newName" required placeholder="e.g. Alex Cruz" class="w-full text-sm rounded-xl border-slate-200 focus:ring-[#EDC92C] focus:border-[#EDC92C]">
                </div>
                <div>
                    <label class="block font-semibold text-slate-700 mb-1">Email Address</label>
                    <input type="email" x-model="newEmail" required placeholder="staff@imaginedhotel.com" class="w-full text-sm rounded-xl border-slate-200 focus:ring-[#EDC92C] focus:border-[#EDC92C]">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Phone Number</label>
                        <input type="tel" x-model="newPhone" placeholder="0917-000-0000" class="w-full text-sm rounded-xl border-slate-200 focus:ring-[#EDC92C] focus:border-[#EDC92C]">
                    </div>
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Role</label>
                        <select x-model="newRole" class="w-full text-sm rounded-xl border-slate-200 focus:ring-[#EDC92C] focus:border-[#EDC92C]">
                            <option value="Administrator">Administrator</option>
                            <option value="Guest">Guest</option>
                        </select>
                    </div>
                </div>
                <div class="flex gap-2 pt-3">
                    <button type="button" @click="showAddModal = false" class="flex-1 py-2.5 rounded-xl border border-slate-200 text-slate-700 font-semibold hover:bg-slate-50">Cancel</button>
                    <button type="submit" class="flex-1 py-2.5 rounded-xl bg-[#06923E] hover:bg-[#057a34] text-white font-bold">Create Account</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Role Modal -->
    <div x-show="editingUser !== null" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 p-4">
        <div @click.outside="editingUser = null" class="bg-white rounded-2xl max-w-sm w-full p-6 shadow-2xl space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <h3 class="text-base font-bold text-slate-900">Edit Role</h3>
                <button type="button" @click="editingUser = null" class="text-slate-400 hover:text-slate-700"><i class="ri-close-line text-xl"></i></button>
            </div>
            <div class="text-xs space-y-3">
                <p class="text-slate-600">Assign system role for <strong class="text-slate-900" x-text="editingUser?.name"></strong>:</p>
                <select x-model="editRoleValue" class="w-full text-sm rounded-xl border-slate-200 focus:ring-[#EDC92C] focus:border-[#EDC92C]">
                    <option value="Administrator">Administrator</option>
                    <option value="Guest">Guest</option>
                </select>
            </div>
            <div class="flex gap-2 pt-2">
                <button type="button" @click="editingUser = null" class="flex-1 py-2.5 rounded-xl border border-slate-200 text-slate-700 text-xs font-semibold hover:bg-slate-50">Cancel</button>
                <button type="button" @click="saveRole()" class="flex-1 py-2.5 rounded-xl bg-[#06923E] hover:bg-[#057a34] text-white text-xs font-bold">Save Role</button>
            </div>
        </div>
    </div>
</div>
@endsection
