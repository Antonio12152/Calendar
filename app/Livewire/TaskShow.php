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

    public function toggleTask(Request $request, $task_id)
    {
        if (!$request->session()->has('open_tasks')) {
             $request->session()->put('open_tasks', []);
        }
        if (in_array($task_id, $request->session()->get('open_tasks', []))) {
            $save = $request->session()->get('open_tasks', []);
            $request->session()->pull('open_tasks', []);
            $request->session()->put('open_tasks', array_diff($save, [$task_id]));
        } else {
            $request->session()->push('open_tasks', $task_id);
        }

        $this->refreshTask();
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
