<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Scholarship;
use Illuminate\Http\Request;

class ScholarshipController extends Controller
{
    /**
     * GET /student/scholarships — show paginated scholarships with filters
     */
    public function index(Request $request)
    {
        $query = Scholarship::where('is_active', true)
            ->where('deadline', '>=', now()->startOfDay());

        if ($request->filled('provider')) {
            $query->where('provider', $request->provider);
        }

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('municipality')) {
            $query->where(function ($q) use ($request) {
                $q->where('municipality', 'like', '%' . $request->municipality . '%')
                  ->orWhere('municipality', 'All')
                  ->orWhereNull('municipality');
            });
        }

        $scholarships = $query->orderBy('deadline', 'asc')->paginate(9)->withQueryString();

        return view('student.scholarships.index', compact('scholarships'));
    }

    /**
     * GET /student/scholarships/{id} — show single scholarship
     */
    public function show($id)
    {
        $scholarship = Scholarship::where('is_active', true)->findOrFail($id);

        return view('student.scholarships.show', compact('scholarship'));
    }

    /**
     * GET /browse — public scholarship listing (no auth required)
     */
    public function publicIndex(Request $request)
    {
        $query = Scholarship::where('is_active', true)
            ->where('deadline', '>=', now()->startOfDay());

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('provider')) {
            $query->where('provider', $request->provider);
        }

        $scholarships = $query->orderBy('deadline', 'asc')->paginate(9)->withQueryString();

        return view('public.browse', compact('scholarships'));
    }
}