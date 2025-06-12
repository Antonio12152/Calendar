<?php

namespace App\Livewire;

use Carbon\Carbon;
use Livewire\Component;

class JobEdit extends Component
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
        'start' => 'required|date|after_or_equal:project_start',
        'end' => 'required|date|after:start|before_or_equal:project_end'
    ];

    protected $messages = [
        'name.required' => 'Das Namefeld ist erforderlich.',
        'description.required' => 'Das Beschreibungsfeld ist erforderlich.',
        'start.after_or_equal' => 'Das Startfeld muss ein Datum nach dem aktuellen Datum und Uhrzeit sein.',
        'end.after' => 'Das Endefeld muss ein Datum nach dem Startfeld und vor dem Projektenddatum sein.',
        'end.before_or_equal' => 'Das Endefeld muss ein Datum nach dem Startfeld und vor dem Projektenddatum sein.',
    ];

    public function mount($job = null)
    {
        if ($job) {
            if (!$job->project_id || !$job->task_id)  return redirect()->route('home');
            $this->job = $job;
            $this->project_id = $job->project_id;
            $this->task_id = $job->task_id;
            $this->description = $job->description;
            $this->start = $job->start;
            $this->end = $job->end;
        }
    }

    public function save()
    {
        $this->validate();

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
        return view('livewire.job-edit');
    }
}
