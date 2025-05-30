<?php

namespace App\Livewire;

use App\Models\Job;
use Livewire\Component;

class JobCreate extends Component
{
    public $description = '';
    public $project_id = null;
    public $task_id = null;
    public $job = null;
    public $start = null;
    public $end = null;

    protected $rules = [
        'description' => 'required|min:10',
        'project_id' => 'required|integer',
        'task_id' => 'required|integer',
        'start' => 'required|date',
        'end' => 'required|date'
    ];

    public function mount($project_id = null, $task_id = null)
    {
        if (!$project_id || !$task_id)  return redirect()->route('home');
        $this->project_id = $project_id;
        $this->task_id = $task_id;
    }

    public function save()
    {
        $this->validate();

        $this->job = new Job();
        $this->job->project_id = $this->project_id;
        $this->job->task_id = $this->task_id;
        $this->job->description = $this->description;
        $this->job->start = $this->start;
        $this->job->end = $this->end;
        $this->job->save();

        session()->flash('message', 'Job created successfully.');

        return redirect()->route('home', ['task_id' => $this->job->task_id, 'project_id' => $this->job->project_id]); #change
    }

    public function render()
    {
        return view('livewire.job-create');
    }
}
