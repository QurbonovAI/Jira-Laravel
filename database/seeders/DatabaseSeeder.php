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
            'full_name' => 'Ozodbek Qurbonov',
            'email' => 'qurbonovo2008@gmail.com',
            'password' => bcrypt('2008Ozodbek!@#$'),
            'is_admin' => true,
            'is_active' => true,
        ]);
    } 
}
