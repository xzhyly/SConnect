<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Scholarship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $scholarships = Scholarship::where('is_active', true)
            ->where('deadline', '>=', now())
            ->where(function ($q) use ($user) {
                $q->where('minimum_gwa', '<=', $user->gwa)
                    ->orWhereNull('minimum_gwa');
            })
            ->where(function ($q) use ($user) {
                $q->where('required_course', $user->course)
                    ->orWhereNull('required_course');
            })
            ->where(function ($q) use ($user) {
                $q->where('municipality', $user->municipality)
                    ->orWhereNull('municipality');
            })
            ->orderBy('deadline', 'asc')
            ->take(6)
            ->get();

        $stats = [
            'total'      => Scholarship::where('is_active', true)->count(),
            'matched'    => $scholarships->count(),
            'bookmarked' => $user->bookmarks()->count(),
        ];

        $upcomingDeadlines = Scholarship::where('is_active', true)
            ->whereNotNull('deadline')
            ->where('deadline', '>=', now())  // ← dagdag ito
            ->orderBy('deadline', 'asc')
            ->take(4)
            ->get();

        $bookmarkedIds = $user->bookmarks()->pluck('scholarship_id')->toArray();

        return view('student.dashboard', compact(
            'user',
            'scholarships',
            'stats',
            'upcomingDeadlines',
            'bookmarkedIds'
        ));
    }

    public function notifications()
    {
        $user = auth()->user();

        $notifications = Notification::where('user_id', $user->id)
            ->with('scholarship')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('student.notifications', compact('notifications'));
    }

    public function markRead(Request $request, $id)
    {
        $notification = Notification::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $notification->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }

    public function profile()
    {
        $user = auth()->user();
        return view('student.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name'         => 'required|string|max:255',
            'municipality' => 'required|string',
            'course'       => 'required|string',
            'gwa'          => 'required|numeric|min:1.00|max:5.00',
            'year_level'   => 'required|integer|min:1|max:5',
            'password'     => 'nullable|min:8|confirmed',
        ]);

        $user->update([
            'name'                => $request->name,
            'municipality'        => $request->municipality,
            'course'              => $request->course,
            'gwa'                 => $request->gwa,
            'year_level'          => $request->year_level,
            'email_notifications' => $request->boolean('email_notifications'),
        ]);

        if ($request->filled('password')) {
            $user->update([
                'password' => Hash::make($request->password)
            ]);
        }

        return back()->with('success', 'Profile updated successfully!');
    }

    public function toggleAlerts(Request $request)
    {
        $user = auth()->user();
        $user->email_notifications = !$user->email_notifications;
        $user->save();

        return response()->json([
            'success' => true,
            'enabled' => $user->email_notifications
        ]);
    }
}
