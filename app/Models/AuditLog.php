<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class AuditLog extends Model
{
    protected $table = 'audit_logs';

    protected $primaryKey = 'audit_logs_id';

    public $timestamps = false; // only created_at is stored

    protected $fillable = [
        'user_id',
        'actor_name',
        'action_type',
        'auditable_type',
        'auditable_id',
        'details',
        'old_values',
        'new_values',
        'created_at',
    ];

    protected function casts(): array
    {
        return [
            'old_values' => 'array',
            'new_values' => 'array',
            'created_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function auditable(): MorphTo
    {
        return $this->morphTo();
    }

    public function scopeFilter(Builder $query, ?string $actionType, ?string $search): Builder
    {
        return $query
            ->when($actionType && $actionType !== 'ALL', fn (Builder $q) => $q->where('action_type', $actionType))
            ->when(filled($search), function (Builder $q) use ($search) {
                $term = '%' . trim($search) . '%';
                $q->where(function (Builder $sub) use ($term) {
                    $sub->where('actor_name', 'like', $term)
                        ->orWhere('action_type', 'like', $term)
                        ->orWhere('details', 'like', $term);
                });
            });
    }
}