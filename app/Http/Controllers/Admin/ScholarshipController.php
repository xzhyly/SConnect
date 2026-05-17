<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Scholarship;
use Illuminate\Http\Request;

class ScholarshipController extends Controller
{
    /**
     * GET /admin/scholarships — show scholarships with filters
     */
    public function index(Request $request)
    {
        $query = Scholarship::query();

        if ($request->filled('provider')) {
            $query->where('provider', $request->provider);
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $scholarships = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        $stats = [
            'total'    => Scholarship::count(),
            'active'   => Scholarship::where('is_active', true)->count(),
            'inactive' => Scholarship::where('is_active', false)->count(),
        ];

        return view('admin.scholarships.index', compact('scholarships', 'stats'));
    }

    /**
     * PATCH /admin/scholarships/{id}/toggle — toggle active/inactive via JS fetch
     */
    public function toggle($id)
    {
        $scholarship = Scholarship::findOrFail($id);
        $scholarship->update(['is_active' => !$scholarship->is_active]);

        return response()->json([
            'success'   => true,
            'is_active' => $scholarship->is_active,
            'message'   => $scholarship->is_active ? 'Scholarship activated.' : 'Scholarship deactivated.',
        ]);
    }
}