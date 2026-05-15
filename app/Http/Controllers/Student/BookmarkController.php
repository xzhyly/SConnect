<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Bookmark;
use App\Models\Scholarship;
use Illuminate\Http\Request;

class BookmarkController extends Controller
{
    public function index()
    {
        $bookmarks = auth()->user()
            ->bookmarks()
            ->with('scholarship')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('student.bookmarks', compact('bookmarks'));
    }

    public function store(Request $request, $id)
    {
        $scholarship = Scholarship::where('is_active', true)->findOrFail($id);

        Bookmark::firstOrCreate([
            'user_id'        => auth()->id(),
            'scholarship_id' => $scholarship->id,
        ]);

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'bookmarked' => true]);
        }

        return back()->with('success', 'Scholarship bookmarked!');
    }

    public function destroy(Request $request, $id)
    {
        Bookmark::where('user_id', auth()->id())
            ->where('scholarship_id', $id)
            ->delete();

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'bookmarked' => false]);
        }

        return back()->with('success', 'Bookmark removed.');
    }
}