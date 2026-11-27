<?php

namespace App\Services;

use App\Models\AuditLog;
use App\Models\User;
use  Illuminate\Database\Eloquent\Model;

class AuditLogService
{
     public static function record(
        string $actionType,
        string $details,
        ?Model $auditable = null,
        ?array $oldValues = null,
        ?array $newValues = null,
        ?User $actor = null
    ): AuditLog {
        $user = $actor ?? auth()->user();

        return AuditLog::create([
            'user_id'        => $user?->id,
            'actor_name'     => $user?->name ?? 'System / Guest',
            'action_type'    => $actionType,
            'auditable_type' => $auditable?->getMorphClass(),
            'auditable_id'   => $auditable?->getKey(),
            'details'        => $details,
            'old_values'     => $oldValues,
            'new_values'     => $newValues,
            'created_at'     => now(),
        ]);
    }   
}