<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Session;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = ['full_name', 'email', 'password', 'is_admin', 'is_active'];

    public function projects()
    {
        return $this->hasMany(Project::class, 'owner_id');
    }

    public function assignedIssues()
    {
        return $this->hasMany(Issue::class, 'assignee_id');
    }

    public function reportedIssues()
    {
        return $this->hasMany(Issue::class, 'reporter_id');
    }

    public function penalties()
    {
        return $this->hasMany(Penalty::class, 'user_id');
    }
}
