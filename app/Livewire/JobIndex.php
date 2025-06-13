<?php

namespace App\Livewire;

use App\Models\Job;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class JobIndex extends Component
{
    public $projects = null;
    public function render()
    {
        $colors = ['blue', 'green', 'navy', 'indigo', 'dodgerblue', 'mediumorchid', 'lightslategray', 'teal'];
        $jobs = Job::with(['user', 'task', 'project'])->whereHas('user', function ($query) {
            $query->where('user_id', '=', Auth::id());
        })->get();
        $this->projects = $jobs->map(function ($j) use ($colors) {
            return [
                'id' => $j->id,
                'project_id' => $j->project_id,
                'task_id' => $j->task_id,
                'title' => $j->project->name . ' ' . $j->task->name,
                'start' => $j->start,
                'end' => $j->end,
                'color' => $colors[$j->id % count($colors)],
            ];
        });
        return view('livewire.job-index', ['projects' => $this->projects]);
    }
}
