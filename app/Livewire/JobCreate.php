<?php

namespace App\Livewire;

use App\Models\Job;
use App\Models\Project;
use Livewire\Component;
use Carbon\Carbon;

class JobCreate extends Component
{
    public $description = '';
    public $project_id = null;
    public $task_id = null;
    public $job = null;
    public $start = null;
    public $end = null;
    public $current_time = null;
    public $project_start = null;
    public $project_end = null;

    protected $rules = [
        'description' => 'required|min:10',
        'project_id' => 'required|integer',
        'task_id' => 'required|integer',
        'start' => 'required|date|after:current_time|after_or_equal:project_start',
        'end' => 'required|date|after:start|before_or_equal:project_end'
    ];

    protected $messages = [
        'name.min' => 'Das Namefeld ist erforderlich.',
        'description.min' => 'Das Beschreibungsfeld ist erforderlich.',
        'start.after' => 'Das Startfeld muss ein Datum nach dem aktuellen Datum und Uhrzeit sein.',
        'start.after_or_equal' => 'Das Startfeld muss ein Datum nach dem aktuellen Datum und Uhrzeit sein.',
        'end.after' => 'Das Endefeld muss ein Datum nach dem Startfeld und vor dem Projektenddatum sein.',
        'end.before_or_equal' => 'Das Endefeld muss ein Datum nach dem Startfeld und vor dem Projektenddatum sein.',
    ];

    public function mount($project_id = null, $task_id = null)
    {
        if (!$project_id || !$task_id)  return redirect()->route('home');
        $this->current_time = Carbon::now();
        $this->project_id = $project_id;
        $this->task_id = $task_id;
        $project = Project::where('id', $project_id)->first();
        $this->project_start = $project->start;
        $this->project_end = $project->end;
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

        return redirect()->route('home', ['task_id' => $this->job->task_id, 'project_id' => $this->job->project_id]);
    }
    public function render()
    {
        return view('livewire.job-create');
    }
}
