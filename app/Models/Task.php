<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    protected $fillable = ['name', 'description', 'project_id'];
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    public function job(): HasMany
    {
        return $this->hasMany(Job::class);
    }
}
