<?php

namespace App\Http\Controllers;

use App\Models\Issue;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class DashboardController extends Controller
{
   public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        try {
            $allProjects = Project::with('owner')->get();
            $allIssues = Issue::with(['project', 'assignee', 'reporter'])->get();
            $recentIssues = Issue::getRecentIssues($user->id, 5);
            $users = User::where('is_active', true)->get();

            $statistics = [
                'total_issues' => $allIssues->count(),
                'in_progress_count' => $allIssues->where('status', 'in_progress')->count(),
                'done_count' => $allIssues->where('status', 'done')->count(),
                'my_issues' => $allIssues->where('assignee_id', $user->id)->count(),
            ];
        } catch (\Exception $e) {
            return view('dashboard', [
                'user' => $user,
                'allProjects' => collect(),
                'allIssues' => collect(),
                'recentIssues' => collect(),
                'users' => collect(),
                'statistics' => ['total_issues' => 0, 'in_progress_count' => 0, 'done_count' => 0, 'my_issues' => 0],
                'error' => 'Ma\'lumotlarni yuklashda xato: ' . $e->getMessage()
            ]);
        }

        return view('dashboard', compact('user', 'allProjects', 'allIssues', 'recentIssues', 'users', 'statistics'));
    }
}
