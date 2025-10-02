<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
   public function __construct()
{
    $this->middleware('auth');
    $this->middleware('admin')->only(['create', 'store', 'edit', 'update', 'destroy']);
}


    public function index()
    {
        $projects = Project::with('owner')->get();
        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        return view('projects.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'status' => 'required|in:active,completed',
        ]);

        try {
            $project = Project::create([
                'name' => $validated['name'],
                'description' => $validated['description'],
                'status' => $validated['status'],
                'owner_id' => Auth::id(),
            ]);

            return $request->expectsJson()
                ? response()->json(['success' => true, 'message' => 'Loyiha muvaffaqiyatli yaratildi', 'project' => $project])
                : redirect()->route('dashboard')->with('success', 'Loyiha muvaffaqiyatli yaratildi');
        } catch (\Exception $e) {
            return $request->expectsJson()
                ? response()->json(['success' => false, 'message' => 'Xatolik: ' . $e->getMessage()], 500)
                : redirect()->route('dashboard')->with('error', 'Xatolik: ' . $e->getMessage());
        }
    }

    public function show(Project $project)
    {
        $issues = $project->issues()->with(['assignee', 'reporter'])->get();
        return view('projects.show', compact('project', 'issues'));
    }

    public function edit(Project $project)
    {
        if (!Auth::user()->is_admin && $project->owner_id !== Auth::id()) {
            return request()->expectsJson()
                ? response()->json(['success' => false, 'message' => 'Sizda bu loyihani tahrirlash huquqi yo\'q'], 403)
                : redirect()->route('dashboard')->with('error', 'Sizda bu loyihani tahrirlash huquqi yo\'q');
        }
        return view('projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        if (!Auth::user()->is_admin && $project->owner_id !== Auth::id()) {
            return $request->expectsJson()
                ? response()->json(['success' => false, 'message' => 'Sizda bu loyihani tahrirlash huquqi yo\'q'], 403)
                : redirect()->route('dashboard')->with('error', 'Sizda bu loyihani tahrirlash huquqi yo\'q');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'status' => 'required|in:active,completed',
        ]);

        try {
            $project->update($validated);
            return $request->expectsJson()
                ? response()->json(['success' => true, 'message' => 'Loyiha muvaffaqiyatli yangilandi'])
                : redirect()->route('dashboard')->with('success', 'Loyiha muvaffaqiyatli yangilandi');
        } catch (\Exception $e) {
            return $request->expectsJson()
                ? response()->json(['success' => false, 'message' => 'Xatolik: ' . $e->getMessage()], 500)
                : redirect()->route('dashboard')->with('error', 'Xatolik: ' . $e->getMessage());
        }
    }

    public function destroy(Project $project)
    {
        if (!Auth::user()->is_admin && $project->owner_id !== Auth::id()) {
            return request()->expectsJson()
                ? response()->json(['success' => false, 'message' => 'Sizda bu loyihani o\'chirish huquqi yo\'q'], 403)
                : redirect()->route('dashboard')->with('error', 'Sizda bu loyihani o\'chirish huquqi yo\'q');
        }

        try {
            $project->delete();
            return request()->expectsJson()
                ? response()->json(['success' => true, 'message' => 'Loyiha muvaffaqiyatli o\'chirildi'])
                : redirect()->route('dashboard')->with('success', 'Loyiha muvaffaqiyatli o\'chirildi');
        } catch (\Exception $e) {
            return request()->expectsJson()
                ? response()->json(['success' => false, 'message' => 'Xatolik: ' . $e->getMessage()], 500)
                : redirect()->route('dashboard')->with('error', 'Xatolik: ' . $e->getMessage());
        }
    }
}
