<?php

namespace App\Livewire;

use App\Models\Job;
use App\Models\Project;
use App\Models\Task;
use Livewire\Component;
use Carbon\Carbon;
use Illuminate\Http\Client\Request;

class JobCreate extends Component
{
    public $description = '';

    public $job = null;
    public $start = null;
    public $end = null;

    public $project_start = null;
    public $project_end = null;


    public $project_id = '';
    public $task_id = '';
    public $tasks = null;

    protected $rules = [
        'description' => 'required|min:10',
        'project_id' => 'required|integer',
        'task_id' => 'required|integer',
        'start' => 'required|date|after_or_equal:project_start',
        'end' => 'required|date|after:start|before_or_equal:project_end'
    ];

    protected $messages = [
        'name.required' => 'Das Namefeld ist erforderlich.',
        'project_id.required'=> 'Das Projectfeld ist erforderlich.',
        'task_id.required'=> 'Das Taskfeld ist erforderlich.',
        'description.required' => 'Das Beschreibungsfeld ist erforderlich.',
        'start.after_or_equal' => 'Das Startfeld muss ein Datum nach dem aktuellen Datum und Uhrzeit sein.',
        'end.after' => 'Das Endefeld muss ein Datum nach dem Startfeld sein.',
        'end.before_or_equal' => 'Das Endefeld muss ein Datum vor dem Projektenddatum sein.',
    ];
    public function updateproject_id($project_id = null)
    {
        $this->project_id = $project_id;
        if ($this->project_id) {
            $this->tasks = Task::where('project_id', $this->project_id)->get();
            $this->task_id = null;
            $project = Project::where('id', $project_id)->first();
            $this->project_start = $project->start;
            $this->project_end = $project->end;
        } else {
            $this->tasks = [];
        }
    }
    public function mount($project_id = null, $task_id = null)
    {
        // if (!$project_id || !$task_id)  return redirect()->route('home'); https://www.youtube.com/watch?v=JXtZdnUv7IE

        $this->project_id = $project_id;
        $this->task_id = $task_id;
        if ($this->project_id) {
            $this->tasks = Task::where('project_id', $this->project_id)->get();
            $this->task_id = null;
        } else {
            $this->tasks = [];
        }
        if ($project_id && $task_id) {
            $this->project_id = $project_id;
            $this->task_id = $task_id;
            $project = Project::where('id', $project_id)->first();
            $this->project_start = $project->start;
            $this->project_end = $project->end;
        }
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
        $projects = Project::all();
        return view('livewire.job-create', ['projects' => $projects]);
    }
}
