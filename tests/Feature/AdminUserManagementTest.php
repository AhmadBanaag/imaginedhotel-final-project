<?php

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

function seedRoles(): array
{
    $adminRoleId = DB::table('user_roles')->insertGetId([
        'role_name' => 'admin',
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    $guestRoleId = DB::table('user_roles')->insertGetId([
        'role_name' => 'guest',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return ['admin' => $adminRoleId, 'guest' => $guestRoleId];
}

test('admin users directory lists users and filters by role and search query', function () {
    $roles = seedRoles();

    User::factory()->create([
        'name' => 'Ahmad Banaag',
        'email' => 'ahmad@imaginedhotel.com',
        'phone' => '0917-111-2222',
        'role_id' => $roles['admin'],
        'is_active' => true,
    ]);
    User::factory()->create([
        'name' => 'Maria Santos',
        'email' => 'maria@example.com',
        'phone' => '0918-987-6543',
        'role_id' => $roles['guest'],
        'is_active' => true,
    ]);

    $this->get(route('admin.users.index'))
        ->assertOk()
        ->assertSee('Ahmad Banaag')
        ->assertSee('Maria Santos');

    $this->get(route('admin.users.index', ['role_id' => $roles['admin']]))
        ->assertOk()
        ->assertSee('Ahmad Banaag')
        ->assertDontSee('Maria Santos');

    $this->get(route('admin.users.index', ['q' => 'maria@example']))
        ->assertOk()
        ->assertSee('Maria Santos')
        ->assertDontSee('Ahmad Banaag');
});

test('admin can create a new user account with hashed password and role', function () {
    $roles = seedRoles();

    $response = $this->post(route('admin.users.store'), [
        'name' => 'Alex Cruz',
        'email' => 'alex@imaginedhotel.com',
        'phone' => '0917-000-0000',
        'role_id' => $roles['admin'],
        'password' => 'secret123',
        'password_confirmation' => 'secret123',
    ]);

    $response->assertRedirect();

    $user = User::where('email', 'alex@imaginedhotel.com')->first();
    expect($user)->not->toBeNull()
        ->and($user->role_id)->toBe($roles['admin'])
        ->and($user->is_active)->toBeTrue()
        ->and(Hash::check('secret123', $user->password))->toBeTrue();

    $this->assertDatabaseHas('audit_logs', [
        'action_type' => 'USER_CREATED',
        'auditable_type' => User::class,
        'auditable_id' => $user->id,
    ]);
});

test('admin can update user role and toggle active status', function () {
    $roles = seedRoles();
    $user = User::factory()->create([
        'role_id' => $roles['guest'],
        'is_active' => true,
    ]);

    $this->patch(route('admin.users.update-role', $user), [
        'role_id' => $roles['admin'],
    ])->assertRedirect();

    expect($user->fresh()->role_id)->toBe($roles['admin']);

    $this->patch(route('admin.users.toggle-status', $user->id))
        ->assertRedirect();

    expect($user->fresh()->is_active)->toBeFalse();

    $this->assertDatabaseHas('audit_logs', ['action_type' => 'USER_ROLE_UPDATED']);
    $this->assertDatabaseHas('audit_logs', ['action_type' => 'USER_STATUS_CHANGED']);
});
