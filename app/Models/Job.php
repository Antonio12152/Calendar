<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $fillable = ['project_id', 'task_id', 'description', 'start', 'end'];
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    public function task()
    {
        return $this->belongsTo(Task::class);
    }
    public function user()
    {
        return $this->belongsToMany(User::class);
    }
}
