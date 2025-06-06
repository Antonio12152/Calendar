<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'start', 'end'];
    protected $primaryKey = 'id';

    public function task(): HasMany #change
    {
        return $this->hasMany(Task::class);
    }
    public function job(): HasMany
    {
        return $this->hasMany(Job::class);
    }
}
