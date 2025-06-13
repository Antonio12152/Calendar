<?php

namespace App\Livewire;

use App\Models\Job;
use App\Models\Task;
use Livewire\Component;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class TaskShow extends Component
{
    public $tasks = null;

    public function mount($project_id)
    {
        $this->tasks = Task::where('project_id', $project_id)->get();
    }

    public function toggleTask($task_id)
    {
        if (!session()->has('open_tasks')) {
             session()->put('open_tasks', []);
        }
        if (in_array($task_id, session()->get('open_tasks', []))) {
            $save = session()->get('open_tasks', []);
            session()->pull('open_tasks', []);
            session()->put('open_tasks', array_diff($save, [$task_id]));
        } else {
            session()->push('open_tasks', $task_id);
        }

        $this->dispatch('refresh_component');
    }

    public function refreshTask()
    {
        $this->dispatch('$refresh');
    }

    public function render()
    {
        return view('livewire.task-show', ['tasks' => $this->tasks]);
    }
}
