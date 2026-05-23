<?php
namespace App\Http\Controllers\Student;
use App\Http\Controllers\Controller;
use App\Models\Bookmark;
use App\Models\Scholarship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScholarshipController extends Controller
{
    /**
     * GET /student/scholarships — show paginated scholarships with filters
     */
    public function index(Request $request)
    {
        $query = Scholarship::where('is_active', true)
            ->where('deadline', '>=', now()->startOfDay());

        // Provider — checkbox sends array e.g. provider[]=ched&provider[]=lgu
        if ($request->has('provider') && !empty($request->provider)) {
            $providers = (array) $request->provider;
            $query->whereIn('provider', $providers);
        }

        // Search by title
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Municipality — match exact, 'All', or null (open to all)
        if ($request->filled('municipality')) {
            $query->where(function ($q) use ($request) {
                $q->where('municipality', 'like', '%' . $request->municipality . '%')
                  ->orWhere('municipality', 'All')
                  ->orWhereNull('municipality');
            });
        }

        // Course/Program — match exact or null (open to all courses)
        if ($request->filled('course')) {
            $query->where(function ($q) use ($request) {
                $q->where('required_course', $request->course)
                  ->orWhereNull('required_course');
            });
        }

        // Year Level filter:
        // - If user selected a year level → show scholarships specifically
        //   for that year level OR open to all (null year_level)
        // - If scholarship has a specific year_level set and it doesn't match
        //   the selected filter → exclude it (strict match)
        if ($request->filled('year_level')) {
            $selectedYear = (int) $request->year_level;
            $query->where(function ($q) use ($selectedYear) {
                $q->where('year_level', $selectedYear)
                  ->orWhereNull('year_level');
            });
        }

        // GWA filter — show scholarships the student can qualify for
        // PH scale: lower = better (1.00 highest, 5.00 failing)
        // e.g. student GWA = 2.50 → show where minimum_gwa >= 2.50
        if ($request->filled('gwa')) {
            $query->where(function ($q) use ($request) {
                $q->where('minimum_gwa', '>=', (float) $request->gwa)
                  ->orWhereNull('minimum_gwa');
            });
        }

        // Sort
        switch ($request->sort) {
            case 'deadline':
                $query->orderBy('deadline', 'asc');
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'amount':
                $query->orderBy('benefits', 'asc');
                break;
            default: // relevance — soonest deadline first
                $query->orderBy('deadline', 'asc');
        }

        $scholarships = $query->paginate(9)->withQueryString();

        // Pass the authenticated user's year_level so the blade
        // can pre-select or display it
        $userYearLevel = Auth::user()->year_level ?? null;

        return view('student.scholarships.index', compact('scholarships', 'userYearLevel'));
    }

    /**
     * GET /student/scholarships/{id} — show single scholarship
     */
    public function show($id)
    {
        $scholarship = Scholarship::where('is_active', true)->findOrFail($id);

        $isBookmarked = false;
        if (Auth::check()) {
            $isBookmarked = Bookmark::where('user_id', Auth::id())
                ->where('scholarship_id', $scholarship->id)
                ->exists();
        }

        return view('student.scholarships.show', compact('scholarship', 'isBookmarked'));
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

        if ($request->has('provider') && !empty($request->provider)) {
            $query->where('provider', $request->provider);
        }

        $scholarships = $query->orderBy('deadline', 'asc')->paginate(9)->withQueryString();
        return view('public.browse', compact('scholarships'));
    }
}