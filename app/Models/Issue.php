<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    protected $table = 'issues';
    protected $fillable = [
        'title',
        'description',
        'status',
        'priority',
        'estimated_time',
        'spent_time',
        'due_date',
        'project_id',
        'assignee_id',
        'reporter_id'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assignee_id');
    }

    public function reporter()
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }

    public static function getRecentIssues($userId, $limit = 5)
    {
        return self::with(['project', 'assignee', 'reporter'])
            ->where('assignee_id', $userId)
            ->orWhere('reporter_id', $userId)
            ->orderBy('created_at', 'desc')
            ->take($limit)
            ->get();
    }
}
