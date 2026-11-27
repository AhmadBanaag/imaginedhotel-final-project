<?php

use App\Models\AuditLog;
use App\Models\User;
use App\Services\AuditLogService;

test('audit log service records an event with actor, morph target, and json diffs', function () {
    $admin = User::factory()->create(['name' => 'Ahmad Banaag']);

    $log = AuditLogService::record(
        actionType: 'ROOM_STATUS_CHANGE',
        details: 'Marked Room 105 as Unavailable',
        auditable: $admin,
        oldValues: ['status' => 'available'],
        newValues: ['status' => 'unavailable'],
        actor: $admin,
    );

    expect($log)->toBeInstanceOf(AuditLog::class)
        ->and($log->actor_name)->toBe('Ahmad Banaag')
        ->and($log->old_values)->toBe(['status' => 'available'])
        ->and($log->new_values)->toBe(['status' => 'unavailable']);

    $this->assertDatabaseHas('audit_logs', [
        'user_id'        => $admin->id,
        'actor_name'     => 'Ahmad Banaag',
        'action_type'    => 'ROOM_STATUS_CHANGE',
        'auditable_type' => User::class,
        'auditable_id'   => $admin->id,
        'details'        => 'Marked Room 105 as Unavailable',
    ]);
});

test('audit log service falls back to System / Guest when unauthenticated', function () {
    $log = AuditLogService::record(
        actionType: 'CANCELLATION',
        details: 'Guest cancelled booking IH-2026-8398',
    );

    expect($log->user_id)->toBeNull()
        ->and($log->actor_name)->toBe('System / Guest');
});

test('admin audit trails page renders and filters by action_type and search query', function () {
    AuditLogService::record('ROOM_STATUS_CHANGE', 'Marked Room 105 Unavailable');
    AuditLogService::record('PAYMENT_VERIFIED', 'Approved GCash REF-849102 for IH-2026-8492');

    // Unfiltered
    $this->get(route('admin.audit-trails.index'))
        ->assertOk()
        ->assertSee('Marked Room 105 Unavailable')
        ->assertSee('Approved GCash REF-849102');

    // Filter by action_type
    $this->get(route('admin.audit-trails.index', ['action_type' => 'PAYMENT_VERIFIED']))
        ->assertOk()
        ->assertSee('Approved GCash REF-849102')
        ->assertDontSee('Marked Room 105 Unavailable');

    // Search query
    $this->get(route('admin.audit-trails.index', ['q' => 'Room 105']))
        ->assertOk()
        ->assertSee('Marked Room 105 Unavailable')
        ->assertDontSee('Approved GCash REF-849102');
});