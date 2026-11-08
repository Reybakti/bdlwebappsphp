<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ActivityLogger
{
    /**
     * Catat aktivitas pengguna ke database
     *
     * @param string $module Contoh: AUTH, COMPLAINT, WBS, REPORT, PRODUCT
     * @param string $action Contoh: LOGIN, LOGOUT, CREATE, UPDATE, DELETE
     * @param string $description Keterangan yang mudah dipahami
     * @param array|null $changes Data tambahan (lama vs baru)
     */
    public static function log(string $module, string $action, string $description, ?array $changes = null): void
    {
        $user = Auth::user();

        ActivityLog::create([
            'user_id' => $user?->id,
            'user_name' => $user?->name ?? 'Guest / System',
            'user_role' => $user?->role?->name ?? 'N/A',
            'module' => strtoupper($module),
            'action' => strtoupper($action),
            'description' => $description,
            'changes' => $changes,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
        ]);
    }
}