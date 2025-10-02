<?php

namespace App\Http\Controllers;

use App\Models\Issue;
use App\Models\Project;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $reports = [
            'total_projects' => Project::count(),
            'total_tasks' => Issue::count(),
            'completed_tasks' => Issue::where('status', 'done')->count(),
            'overdue_tasks' => Issue::where('status', '!=', 'done')
                ->whereNotNull('due_date')
                ->where('due_date', '<', now())
                ->count(),
        ];

        return request()->ajax() ? view('reports.index', compact('reports')) : view('dashboard', compact('reports'));
    }
}
