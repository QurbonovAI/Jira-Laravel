<?php

namespace App\Http\Controllers;

use App\Models\Penalty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenaltyController extends Controller
{
    public function index()
    {
        $penalties = Penalty::with(['user', 'issue', 'appliedBy'])->get();
        return request()->ajax() ? view('penalties.index', compact('penalties')) : view('dashboard', compact('penalties'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'issue_id' => 'required|exists:issues,id',
            'amount' => 'required|numeric|min:0',
            'reason' => 'required|string|max:255',
        ]);

        Penalty::create($request->all() + ['applied_by' => Auth::id()]);

        return redirect()->route('penalties.index')->with('success', 'Jarima qo\'llanildi!');
    }
}
