<?php

namespace Database\Seeders;

use App\Models\Issue;
use App\Models\Penalty;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
public function run()
    {
        $admin = User::create([
            'full_name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'is_admin' => true,
            'is_active' => true,
        ]);

        $user = User::create([
            'full_name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => bcrypt('password'),
            'is_admin' => false,
            'is_active' => true,
        ]);

        $project = Project::create([
            'name' => 'Test Loyiha',
            'description' => 'Bu test loyihasi.',
            'status' => 'active',
            'owner_id' => $admin->id,
        ]);

        $issue = Issue::create([
            'title' => 'Test Vazifa',
            'description' => 'Bu test vazifasi.',
            'status' => 'todo',
            'priority' => 'medium',
            'estimated_time' => 5,
            'due_date' => now()->addDays(1),
            'project_id' => $project->id,
            'assignee_id' => $user->id,
            'reporter_id' => $admin->id,
        ]);

        Penalty::create([
            'user_id' => $user->id,
            'issue_id' => $issue->id,
            'amount' => 10000,
            'reason' => 'Vazifa kechiktirildi',
            'applied_by' => $admin->id,
        ]);
    } 
}
