<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserRole;
use App\Services\AuditLogService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $roleFilter = $request->query('role_id');
        $search = $request->query('q');

        $users = User::query()
            ->with('role')
            ->filter($roleFilter, $search)
            ->latest('id')
            ->get();

        $roles = UserRole::query()->orderBy('role_id')->get();

        return view('admin.users.index', compact('users', 'roles', 'roleFilter', 'search'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'phone'    => ['nullable', 'string', 'max:30'],
            'role_id'  => ['nullable', 'exists:user_roles,role_id'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $parts = preg_split('/\s+/', trim($validated['name']), 2);

        $user = User::create([
            'name'       => $validated['name'],
            'first_name' => $parts[0] ?? $validated['name'],
            'last_name'  => $parts[1] ?? null,
            'email'      => $validated['email'],
            'phone'      => $validated['phone'] ?? null,
            'role_id'    => $validated['role_id'] ?? null,
            'password'   => $validated['password'],
            'is_active'  => true,
        ]);

        AuditLogService::record(
            actionType: 'USER_CREATED',
            details: "Created account for {$user->name} ({$user->email})",
            auditable: $user,
            newValues: ['email' => $user->email, 'role_id' => $user->role_id]
        );

        return back()->with('success', "Account created for {$user->name} ({$user->email}).");
    }

    public function updateRole(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'role_id' => ['required', 'exists:user_roles,role_id'],
        ]);

        $oldRoleId = $user->role_id;
        $user->update(['role_id' => $validated['role_id']]);
        $user->load('role');

        AuditLogService::record(
            actionType: 'USER_ROLE_UPDATED',
            details: "Updated role for {$user->name} to " . ($user->role?->role_name ?? $validated['role_id']),
            auditable: $user,
            oldValues: ['role_id' => $oldRoleId],
            newValues: ['role_id' => (int) $validated['role_id']]
        );

        return back()->with('success', "{$user->name}'s role has been updated.");
    }

    public function toggleStatus($id): RedirectResponse
    {
        $user = User::findOrFail($id);
        $wasActive = (bool) $user->is_active;
        $user->is_active = ! $wasActive;
        $user->save();

        $status = $user->is_active ? 'activated' : 'deactivated';

        AuditLogService::record(
            actionType: 'USER_STATUS_CHANGED',
            details: "User {$user->name} ({$user->email}) was {$status}",
            auditable: $user,
            oldValues: ['is_active' => $wasActive],
            newValues: ['is_active' => $user->is_active]
        );

        return back()->with('success', "User {$user->name} ({$user->email}) has been {$status} successfully.");
    }
}
