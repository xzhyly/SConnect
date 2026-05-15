<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Scholarship;
use App\Models\SyncLog;
use App\Models\User;
use App\Models\Notification;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_scholarships'  => Scholarship::count(),
            'active_scholarships' => Scholarship::where('is_active', true)->count(),
            'total_students'      => User::where('is_admin', false)->count(),
            'last_sync'           => SyncLog::latest('created_at')->first(),
            'total_syncs'         => SyncLog::count(),
        ];

        $recentSyncLogs = SyncLog::orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // For Chart.js — scholarship count per provider
        $scholarshipsByProvider = Scholarship::selectRaw('provider, COUNT(*) as count')
            ->groupBy('provider')
            ->get();

        $recentStudents = User::where('is_admin', false)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'recentSyncLogs',
            'scholarshipsByProvider',
            'recentStudents'
        ));
    }
}