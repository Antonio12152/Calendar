<?php

namespace App\Livewire;

use App\Models\Project;
use Carbon\Carbon;
use Livewire\Component;

class ProjectCreate extends Component
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
        'start' => 'required|date|after:current_time',
        'end' => 'required|date|after:start',
    ];

    public function mount()
    {
        $this->current_time = Carbon::now();
    }

    public function save()
    {
        $this->validate();

        $this->project = new Project();

        $this->project->name = $this->name;
        $this->project->description = $this->description;
        $this->project->start = $this->start;
        $this->project->end = $this->end;
        $this->project->save();


        session()->flash('message', 'Project created successfully.');

        return redirect()->route('home', $this->project); # change
    }

    public function render()
    {
        return view('livewire.project-create');
    }
}
