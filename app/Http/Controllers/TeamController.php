<?php

namespace App\Http\Controllers;

use App\Models\Issue;
use App\Models\Penalty;
use App\Models\User;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index()
    {
        $users = User::where('is_active', true)->get()->map(function ($user) {
            $user->total_tasks = Issue::where('assignee_id', $user->id)->count();
            $user->completed_tasks = Issue::where('assignee_id', $user->id)->where('status', 'done')->count();
            $user->overdue_tasks = Issue::where('assignee_id', $user->id)
                ->where('status', '!=', 'done')
                ->whereNotNull('due_date')
                ->where('due_date', '<', now())
                ->count();
            $user->total_penalties = Penalty::where('user_id', $user->id)->sum('amount');
            return $user;
        });

        return request()->ajax() ? view('team.index', compact('users')) : view('dashboard', compact('users'));
    }
}
