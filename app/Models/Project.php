<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'start', 'end'];
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }
    public function job(): HasMany
    {
        return $this->hasMany(Job::class);
    }
}
