<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{

    protected $fillable = ['name', 'description', 'owner_id'];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function issues()
    {
        return $this->hasMany(Issue::class);  // Vazifalar loyihaga bog'langan
    }

    public function getAllProjects()
    {
        return self::with('owner')->get();
    }
}
