<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['title', 'description', 'status', 'priority', 'board_id', 'assignee_id', 'reporter_id'];

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assignee_id');
    }

    public function reporter()
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }

    public function getAllTasks()
    {
        return self::with(['assignee', 'reporter'])->get();
    }

    public function getRecentTasks($userId, $limit)
    {
        return self::where('assignee_id', $userId)
            ->orWhere('reporter_id', $userId)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }
}
