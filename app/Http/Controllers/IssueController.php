<?php

namespace App\Http\Controllers;

use App\Models\Issue;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class IssueController extends Controller
{
   public function index()
    {
        try {
            $issues = Issue::with(['project', 'assignee', 'reporter'])->get();
            return request()->ajax() ? view('issues.index', compact('issues')) : view('dashboard', compact('issues'));
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ma\'lumotlarni yuklashda xato: ' . $e->getMessage()], 500);
        }
    }

public function create()
{
    try {
        $projects = Project::where('status', 'active')->get();
        
        $users = User::all(); 
        
        return view('issues.create', compact('projects', 'users'));
    } catch (\Exception $e) {
        return back()->withErrors(['error' => 'Xato: ' . $e->getMessage()]);
    }
}
    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'status' => 'in:todo,in_progress,done',
                'priority' => 'in:low,medium,high,urgent',
                'estimated_time' => 'required|integer|min:0',
                'due_date' => 'nullable|date',
                'project_id' => 'required|exists:projects,id',
                'assignee_id' => 'nullable|exists:users,id',
            ]);

            Issue::create($request->all() + ['reporter_id' => Auth::id(), 'status' => $request->status ?? 'todo']);

            return redirect()->route('issues.index')->with('success', 'Vazifa muvaffaqiyatli yaratildi!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Vazifa yaratishda xato: ' . $e->getMessage()]);
        }
    }

    public function show(Issue $issue)
    {
        try {
            return view('issues.show', compact('issue'));
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Vazifani ko\'rishda xato: ' . $e->getMessage()]);
        }
    }

    public function edit(Issue $issue)
    {
        try {
            $projects = Project::all();
            $users = User::where('is_active', true)->get();
            return view('issues.edit', compact('issue', 'projects', 'users'));
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Vazifani tahrirlash sahifasini yuklashda xato: ' . $e->getMessage()]);
        }
    }

    public function update(Request $request, Issue $issue)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'status' => 'in:todo,in_progress,done',
                'priority' => 'in:low,medium,high,urgent',
                'estimated_time' => 'required|integer|min:0',
                'spent_time' => 'nullable|integer|min:0',
                'due_date' => 'nullable|date',
                'project_id' => 'required|exists:projects,id',
                'assignee_id' => 'nullable|exists:users,id',
            ]);

            $issue->update($request->all());
            return redirect()->route('issues.index')->with('success', 'Vazifa muvaffaqiyatli yangilandi!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Vazifani yangilashda xato: ' . $e->getMessage()]);
        }
    }

    public function destroy(Issue $issue)
    {
        try {
            $issue->delete();
            return redirect()->route('issues.index')->with('success', 'Vazifa muvaffaqiyatli o\'chirildi!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Vazifani o\'chirishda xato: ' . $e->getMessage()]);
        }
    }

    public function complete(Request $request)
    {
        try {
            $request->validate(['issue_id' => 'required|exists:issues,id']);
            $issue = Issue::findOrFail($request->issue_id);
            $issue->status = 'done';
            $issue->save();

            return response()->json(['success' => true, 'message' => 'Vazifa muvaffaqiyatli tugallandi!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Vazifani tugallashda xato: ' . $e->getMessage()], 500);
        }
    }
}
