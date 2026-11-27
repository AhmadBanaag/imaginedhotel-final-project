<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public function index(Request $request)
    {
        $actionType = $request->query('action_type', 'ALL');
        $search = $request->query('q');

        $logs = AuditLog::query()
            ->filter($actionType, $search)
            ->latest('created_at')
            ->paginate(20)
            ->withQueryString();

        return view('admin.audit-trails.index', compact('logs', 'actionType', 'search'));
    }
}