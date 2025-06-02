<?php

namespace App\Livewire;

use App\Models\Job;
use App\Models\Task;
use Livewire\Component;

class TaskShow extends Component
{
    public $tasks = null;

    public function mount($project_id)
    {
        $this->tasks = Task::where('project_id', $project_id)->get();
    }
    public function render()
    {
        return view('livewire.task-show', ['tasks' => $this->tasks]);
    }
}
