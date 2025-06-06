<?php

namespace App\Livewire;

use App\Models\Project;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;

class ProjectEdit extends Component
{
    public $name = '';
    public $description = '';
    public $project = null;
    public $start = null;
    public $end = null;
    public $current_time = null;

    protected $rules = [
        'name' => 'required|min:4',
        'description' => 'required|min:10',
        'start' => 'required|date:current_time',
        'end' => 'required|date|after:start',
    ];

    protected $messages = [
        'name.required' => 'Das Namefeld ist erforderlich.',
        'description.required' => 'Das Beschreibungsfeld ist erforderlich.',
        'start.after' => 'Das Startfeld muss ein Datum nach dem aktuellen Datum und Uhrzeit sein.',
        'end.after' => 'Das Endefeld muss ein Datum nach dem Startfeld sein.',
    ];

    public function mount($project = null)
    {
        $this->project = $project;
        if ($project) {
            $this->name = $project->name;
            $this->description = $project->description;
            $this->start =  $project->start;
            $this->end = $project->end;
        }
        $this->current_time = Carbon::now();
    }

    public function save()
    {
        $this->validate();

        $this->project->name = $this->name;
        $this->project->description = $this->description;
        $this->project->start = $this->start;
        $this->project->end = $this->end;
        $this->project->save();

        session()->flash('message', 'Project updated successfully.');

        return redirect()->route('home'); # change
    }
    public function render(Project $project)
    {
        return view('livewire.project-edit', [
            'project' => $project,
        ]);
    }
}
