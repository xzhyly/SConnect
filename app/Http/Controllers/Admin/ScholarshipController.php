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

        if ($request->filled('source_type')) {
            $query->where('source_type', $request->source_type);
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
            'manual'   => Scholarship::where('source_type', 'manual')->count(),
        ];

        return view('admin.scholarships.index', compact('scholarships', 'stats'));
    }

    /**
     * GET /admin/scholarships/create — show form to manually add a scholarship
     */
    public function create()
    {
        return view('admin.scholarships.create');
    }

    /**
     * POST /admin/scholarships — store a manually added scholarship
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'             => 'required|string|max:255',
            'organization_name' => 'required|string|max:255',
            'description'       => 'nullable|string',
            'deadline'          => 'nullable|date|after_or_equal:today',
            'minimum_gwa'       => 'nullable|numeric|min:1.00|max:5.00',
            'required_course'   => 'nullable|string|max:255',
            'municipality'      => 'nullable|string|max:100',
            'benefits'          => 'nullable|string',
            'application_link'  => 'nullable|url|max:500',
        ]);

        Scholarship::create([
            'title'             => $validated['title'],
            'provider'          => 'manual',
            'organization_name' => $validated['organization_name'],
            'description'       => $validated['description'] ?? null,
            'deadline'          => $validated['deadline'] ?? null,
            'minimum_gwa'       => $validated['minimum_gwa'] ?? null,
            'required_course'   => $validated['required_course'] ?? null,
            'municipality'      => $validated['municipality'] ?? null,
            'benefits'          => $validated['benefits'] ?? null,
            'application_link'  => $validated['application_link'] ?? null,
            'source_url'        => null,   // manual entries have no source URL
            'source_type'       => 'manual',
            'is_active'         => true,
        ]);

        return redirect()->route('admin.scholarships')
            ->with('success', 'Scholarship added successfully.');
    }

    /**
     * GET /admin/scholarships/{id}/edit — show edit form (manual only)
     */
    public function edit($id)
    {
        $scholarship = Scholarship::findOrFail($id);

        // Only manual entries can be edited through this form
        if ($scholarship->source_type !== 'manual') {
            return redirect()->route('admin.scholarships')
                ->with('error', 'API-synced scholarships cannot be edited manually.');
        }

        return view('admin.scholarships.edit', compact('scholarship'));
    }

    /**
     * PUT /admin/scholarships/{id} — update a manually added scholarship
     */
    public function update(Request $request, $id)
    {
        $scholarship = Scholarship::findOrFail($id);

        if ($scholarship->source_type !== 'manual') {
            return redirect()->route('admin.scholarships')
                ->with('error', 'API-synced scholarships cannot be edited manually.');
        }

        $validated = $request->validate([
            'title'             => 'required|string|max:255',
            'organization_name' => 'required|string|max:255',
            'description'       => 'nullable|string',
            'deadline'          => 'nullable|date|after_or_equal:today',
            'minimum_gwa'       => 'nullable|numeric|min:1.00|max:5.00',
            'required_course'   => 'nullable|string|max:255',
            'municipality'      => 'nullable|string|max:100',
            'benefits'          => 'nullable|string',
            'application_link'  => 'nullable|url|max:500',
            'is_active'         => 'boolean',
        ]);

        $scholarship->update([
            'title'             => $validated['title'],
            'organization_name' => $validated['organization_name'],
            'description'       => $validated['description'] ?? null,
            'deadline'          => $validated['deadline'] ?? null,
            'minimum_gwa'       => $validated['minimum_gwa'] ?? null,
            'required_course'   => $validated['required_course'] ?? null,
            'municipality'      => $validated['municipality'] ?? null,
            'benefits'          => $validated['benefits'] ?? null,
            'application_link'  => $validated['application_link'] ?? null,
            'is_active'         => $request->has('is_active'),
        ]);

        return redirect()->route('admin.scholarships')
            ->with('success', 'Scholarship updated successfully.');
    }

    /**
     * DELETE /admin/scholarships/{id} — delete a manual scholarship only
     */
    public function destroy($id)
    {
        $scholarship = Scholarship::findOrFail($id);

        if ($scholarship->source_type !== 'manual') {
            return redirect()->route('admin.scholarships')
                ->with('error', 'API-synced scholarships cannot be deleted here.');
        }

        $scholarship->delete();

        return redirect()->route('admin.scholarships')
            ->with('success', 'Scholarship deleted.');
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