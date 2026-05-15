<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Scholarship;
use Illuminate\Http\Request;

class ScholarshipController extends Controller
{
    public function index(Request $request)
    {
        $query = Scholarship::where('is_active', true);

        // Filter by provider
        if ($request->filled('provider')) {
            $query->where('provider', $request->provider);
        }

        // Filter by course
        if ($request->filled('course')) {
            $query->where(function ($q) use ($request) {
                $q->where('required_course', $request->course)
                  ->orWhereNull('required_course');
            });
        }

        // Filter by municipality
        if ($request->filled('municipality')) {
            $query->where(function ($q) use ($request) {
                $q->where('municipality', $request->municipality)
                  ->orWhereNull('municipality');
            });
        }

        // Filter by GWA eligibility
        if ($request->filled('gwa')) {
            $query->where(function ($q) use ($request) {
                $q->where('minimum_gwa', '>=', $request->gwa)
                  ->orWhereNull('minimum_gwa');
            });
        }

        // Search by title
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $scholarships = $query->orderBy('deadline', 'asc')->paginate(12);

        // Get user's bookmarked IDs for UI state
        $bookmarkedIds = auth()->user()
            ->bookmarks()
            ->pluck('scholarship_id')
            ->toArray();

        return view('student.scholarships', compact('scholarships', 'bookmarkedIds'));
    }

    public function show($id)
    {
        $scholarship = Scholarship::where('is_active', true)
            ->findOrFail($id);

        $isBookmarked = auth()->user()
            ->bookmarks()
            ->where('scholarship_id', $id)
            ->exists();

        return view('student.scholarship-show', compact('scholarship', 'isBookmarked'));
    }
}