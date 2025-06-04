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
    public $open_tasks = [];

    public function mount($project_id)
    {
        $this->tasks = Task::where('project_id', $project_id)->get();
        if (Session::get('open_tasks') != null) {
            $this->open_tasks = Session::get('open_tasks', []);
        }
    }

    public function toggleTask(Request $request, $tasks_id)
    {
        if (in_array($tasks_id, Session::get('open_tasks', []))) {
            $save = Session::get('open_tasks', []);
            Session::pull('open_tasks');
            Session::put('open_tasks', array_diff($save, [$tasks_id]));
        } else {
            Session::push('open_tasks', [$tasks_id] = $tasks_id);
        }
    }

    public function render()
    {
        return view('livewire.task-show', ['tasks' => $this->tasks]);
    }
}
